<?php
session_start();
include 'DBconfig.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email_or_username = $_POST['email_or_username'];
    $password = $_POST['password'];
    
    // Initialize variables
    $user = null;
    $userType = '';

    // Check in admin_users table
    $stmt = $conn->prepare("SELECT id, username FROM admin_users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $email_or_username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $userType = 'admin';
    }

    // Check in Staff table
    if (!$user) {
        $stmt = $conn->prepare("SELECT staff_id AS id, email FROM Staff WHERE email = ? AND password = ?");
        $stmt->bind_param("ss", $email_or_username, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            $userType = 'staff';
        }
    }

    // Check in Coaches table
    if (!$user) {
        $stmt = $conn->prepare("SELECT coach_id AS id, email FROM Coaches WHERE email = ? AND password = ?");
        $stmt->bind_param("ss", $email_or_username, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            $userType = 'coach';
        }
    }

    // Login successful
    if ($user) {
        $_SESSION['logged_in'] = true;
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_type'] = $userType;
        
        // Redirect based on user type
        if ($userType == 'admin') {
            header("Location: admin/dashboard.php");
        } elseif ($userType == 'staff') {
            header("Location: staff/dashboard.php");
        } else {
            header("Location: coach/dashboard.php");
        }
        exit;
    } else {
        $error = "Invalid username/email or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="login-signup-styles.css">
</head>

<body>
  <div class="container">
    <div class="form-container">
      <div class="form-image">
        <img src="img/1.png" alt="Login">
      </div>
      <div class="form-content">
        <h2>Welcome Back!</h2>

        <form method="POST" action="">
        <div class="input-field">
          <label>Email or Username</label>
          <input type="text" name="email_or_username" placeholder="Email or Username" required>
        </div>
        <div class="input-field">
          <label>Password</label>
          <input type="password" name="password" placeholder="Password" required>
          </div>
          <button type="submit" class="btn">Log In</button>
          <?php if (isset($error)) { echo "<p>$error</p>"; } ?>
        </form>
      </div>
    </div>
  </div>
    
</body>

</html>