<?php
session_start();
include 'DBconfig.php';

if (!isset($_SESSION['coach_logged_in']) || $_SESSION['coach_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
$coach_id = $_SESSION['email']; // Store the username for displaying

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Fetch the email and password directly for verification
    $stmt = $conn->prepare("SELECT * FROM Coaches WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password); 
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $_SESSION['coach_logged_in'] = true;
        $_SESSION['email'] = $email;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid email or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="login-styles.css">
</head>
<body>
    <form method="POST" action="">
        <h2>Admin Login</h2>
        <input type="text" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Log In</button>
        <?php if (isset($error)) { echo "<p>$error</p>"; } ?>
    </form>
</body>
</html>
