<?php
session_start();
include 'DBconfig.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM Staff WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password); // Use prepared statements
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $_SESSION['Staff_logged_in'] = true;
        $_SESSION['email'] = $email;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid name or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Login</title>
    <link rel="stylesheet" href="login-styles.css">
</head>
<body>
    <form method="POST" action="">
        <h2>Admin Login</h2>
        <input type="text" name="email" placeholder="email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Log In</button>
        <?php if (isset($error)) { echo "<p>$error</p>"; } ?>
    </form>
</body>
</html>
