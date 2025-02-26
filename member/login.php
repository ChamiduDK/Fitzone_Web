<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
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

                <?php
                session_start();
                if (isset($_SESSION['error_message'])) {
                    echo "<p class='error-message'>{$_SESSION['error_message']}</p>";
                    unset($_SESSION['error_message']);
                }
                ?>
                
                <form action="memberDB.php" method="POST">
                    <div class="input-field">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="input-field">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <button type="submit" name="login" class="btn">Log In</button>
                    <a href="signup.php" class="auth-link">Don't have an account? Sign Up</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
