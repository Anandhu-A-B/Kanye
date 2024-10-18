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

// Insert exercise data into the database (handling form submission)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $squat_weight = $_POST['squat_weight'];
    $squat_reps = $_POST['squat_reps'];
    $bench_weight = $_POST['bench_weight'];
    $bench_reps = $_POST['bench_reps'];
    $row_weight = $_POST['row_weight'];
    $row_reps = $_POST['row_reps'];
    $exercise_date = $_POST['exercise_date'];
    $user_id = 1; // Assuming user ID 1 for simplicity

    $sql = "INSERT INTO workout_logs (user_id, exercise, weight, reps, date_logged) VALUES
        ('$user_id', 'Squat', '$squat_weight', '$squat_reps', '$exercise_date'),
        ('$user_id', 'Bench Press', '$bench_weight', '$bench_reps', '$exercise_date'),
        ('$user_id', 'Barbell Row', '$row_weight', '$row_reps', '$exercise_date')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Workout logged successfully!');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercise Tracker</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to CSS file -->
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
        <h1>Add a New Workout</h1>
        <form id="exerciseForm" method="POST" action="index.php">
            <h3>Squat</h3>
            <label for="squat_weight">Weight (kg):</label>
            <input type="number" id="squat_weight" name="squat_weight" required>
            <label for="squat_reps">Reps:</label>
            <input type="number" id="squat_reps" name="squat_reps" required>

            <h3>Bench Press</h3>
            <label for="bench_weight">Weight (kg):</label>
            <input type="number" id="bench_weight" name="bench_weight" required>
            <label for="bench_reps">Reps:</label>
            <input type="number" id="bench_reps" name="bench_reps" required>

            <h3>Barbell Row</h3>
            <label for="row_weight">Weight (kg):</label>
            <input type="number" id="row_weight" name="row_weight" required>
            <label for="row_reps">Reps:</label>
            <input type="number" id="row_reps" name="row_reps" required>

            <label for="exercise_date">Date:</label>
            <input type="date" id="exercise_date" name="exercise_date" required>

            <button type="submit">Log Workout</button>
        </form>

        <br><br>

        <!-- About Section -->
        <div id="about">
            <h2>About the Exercise Tracker</h2>
            <p>This Exercise Tracker allows you to log your Squats, Bench Press, and Barbell Row progress. Keep track of your workouts and monitor your progress over time!</p>
        </div>

    </div>

    <script src="script.js"></script> <!-- Link to JavaScript file -->
</body>
</html>
