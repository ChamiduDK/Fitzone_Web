<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="login-signup-styles.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <div class="form-image">
                <img src="img/s.jpg" alt="Signup">
            </div>
            <div class="form-content">
                <h2>Join FitZone</h2>

                <?php
                session_start();
                if (isset($_SESSION['error_message'])) {
                    echo "<p class='error-message'>{$_SESSION['error_message']}</p>";
                    unset($_SESSION['error_message']);
                }
                ?>

                <form action="memberDB.php" method="POST">
                    <div class="input-field">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    <div class="input-field">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="input-field">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <div class="input-field">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone" required>
                    </div>
                    <div class="input-field">
                        <label for="address">Address</label>
                        <input type="text" id="address" name="address" required>
                    </div>
                    <div class="input-field">
                        <label for="membership">Membership Type</label>
                        <select id="membership" name="membership" required>
                            <option value="basic">Basic - LKR 5000.00/month</option>
                            <option value="premium">Premium - LKR 10000.00/month</option>
                            <option value="elite">Elite - LKR 15000.00/month</option>
                        </select>
                    </div>
                    <button type="submit" name="signup" class="btn">Sign Up</button>
                    <a href="login.php" class="auth-link">Already have an account? Log In</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
