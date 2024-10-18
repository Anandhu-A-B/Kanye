<?php
session_start();

// Redirect to login if not authenticated
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit();
}

// MySQL Database Connection
$host = 'localhost';
$user = 'root';
$pass = 'root'; // Your MySQL password
$db = 'fitness_tracker'; 

// Create a connection
$conn = new mysqli($host, $user, $pass, $db);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve and display workout logs
$logs = [];
$result = $conn->query("SELECT exercise, weight, reps, date_logged FROM workout_logs WHERE user_id = 1 ORDER BY date_logged DESC");
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $logs[] = $row;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Training Log</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to CSS file -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Chart.js for graphs -->
</head>
<body>

    <!-- Navigation Bar -->
    <nav class="navbar">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="tracking.php">Training Log</a></li>
            <li><a href="#about">About</a></li>
        </ul>
    </nav>

    <div class="container">
        <h1>Training Log</h1>
        <table>
            <thead>
                <tr>
                    <th>Exercise</th>
                    <th>Weight (kg)</th>
                    <th>Reps</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($logs as $log): ?>
                <tr>
                    <td><?= $log['exercise'] ?></td>
                    <td><?= $log['weight'] ?></td>
                    <td><?= $log['reps'] ?></td>
                    <td><?= $log['date_logged'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Exercise Progress Graphs</h2>
        <div class="chart-container">
            <canvas id="squatChart"></canvas>
            <canvas id="benchChart"></canvas>
            <canvas id="rowChart"></canvas>
        </div>

        <br><br>

        <!-- Button to return to main tracking page -->
        <form method="GET" action="index.php">
            <button type="submit">Back to Exercise Tracking</button>
        </form>
    </div>

    <script>
        // Data for each exercise
        const squatData = <?= json_encode($logs); ?>.filter(log => log.exercise === "Squat");
        const benchData = <?= json_encode($logs); ?>.filter(log => log.exercise === "Bench Press");
        const rowData = <?= json_encode($logs); ?>.filter(log => log.exercise === "Barbell Row");

        // Prepare data for Squat chart
        const squatWeights = squatData.map(log => log.weight);
        const squatDates = squatData.map(log => log.date_logged);

        // Squat Chart
        const squatCtx = document.getElementById('squatChart').getContext('2d');
        new Chart(squatCtx, {
            type: 'line',
            data: {
                labels: squatDates,
                datasets: [{
                    label: 'Squat Weight (kg)',
                    data: squatWeights,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            }
        });

        // Bench Press Chart
        const benchWeights = benchData.map(log => log.weight);
        const benchDates = benchData.map(log => log.date_logged);

        const benchCtx = document.getElementById('benchChart').getContext('2d');
        new Chart(benchCtx, {
            type: 'line',
            data: {
                labels: benchDates,
                datasets: [{
                    label: 'Bench Press Weight (kg)',
                    data: benchWeights,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            }
        });

        // Barbell Row Chart
        const rowWeights = rowData.map(log => log.weight);
        const rowDates = rowData.map(log => log.date_logged);

        const rowCtx = document.getElementById('rowChart').getContext('2d');
        new Chart(rowCtx, {
            type: 'line',
            data: {
                labels: rowDates,
                datasets: [{
                    label: 'Barbell Row Weight (kg)',
                    data: rowWeights,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            }
        });
    </script>
</body>
</html>
