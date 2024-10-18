<?php
session_start(); // Start session handling

// Define the correct username and password
$correct_username = 'username';
$correct_password = 'password';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check credentials
    if ($username === $correct_username && $password === $correct_password) {
        $_SESSION['loggedin'] = true; // Set session variable upon successful login
        header("Location: index.php"); // Redirect to the main tracking page
        exit(); // Stop further execution
    } else {
        $error_message = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Exercise Tracker</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to CSS file -->
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <?php if (isset($error_message)): ?>
            <p style="color: red;"><?= $error_message ?></p>
        <?php endif; ?>
        <form method="POST" action="login.php">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
