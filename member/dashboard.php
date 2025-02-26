<?php
include 'DBconfig.php';
session_start();

// Fetch user ID from session
$user_id = $_SESSION["user_id"];

$stmt = $conn->prepare("SELECT username, email, phone, address, membership FROM user WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username, $email, $phone, $address, $membership);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Dashboard</title>
    <link rel="stylesheet" href="dashboard-styles.css">
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <h2>Welcome, <?php echo htmlspecialchars($username); ?></h2>
            <nav>
                <a href="dashboard.php">Dashboard</a>
                <a href="workout-plan.php">Workout Plan</a>
                <a href="profile.php">Profile</a>
                <a href="membership.php">Membership</a>
                <a href="settings.php">Settings</a>
                <a href="logout.php">Log Out</a>
            </nav>
        </aside>
        <main class="content">
            <section id="profile" class="section">
                <h3>Edit Profile</h3>
                <form action="updateProfile.php" method="POST">
                    <div class="input-field">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
                    </div>
                    <div class="input-field">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                    </div>
                    <div class="input-field">
                        <label for="phone">Phone</label>
                        <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>" required>
                    </div>
                    <div class="input-field">
                        <label for="address">Address</label>
                        <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($address); ?>" required>
                    </div>
                    <button type="submit" class="btn">Save Changes</button>
                </form>
            </section>

            <section id="membership" class="section">
                <h3>Manage Membership</h3>
                <p>Your current membership level: <strong><?php echo ucfirst($membership); ?></strong></p>
                <form action="updateMembership.php" method="POST">
                    <div class="input-field">
                        <label for="membership">Membership Type</label>
                        <select id="membership" name="membership">
                            <option value="basic" <?php if ($membership === 'basic') echo 'selected'; ?>>Basic - LKR 5000.00/month</option>
                            <option value="premium" <?php if ($membership === 'premium') echo 'selected'; ?>>Premium - LKR 10000.00/month</option>
                            <option value="elite" <?php if ($membership === 'elite') echo 'selected'; ?>>Elite - LKR 15000.00/month</option>
                        </select>
                    </div>
                    <button type="submit" name="update" class="btn">Update Membership</button>
                    <button type="submit" name="cancel" class="btn secondary-btn">Cancel Membership</button>
                </form>

                <?php if ($membership === 'premium' || $membership === 'elite'|| $membership === 'basic'): ?>
                    <section class="benefits">
                        <h4>Membership Benefits</h4>
                        <ul>
                            <?php if ($membership === 'basic'): ?>
                                <li>Gym Access</li>
                            <?php elseif ($membership === 'premium'): ?>
                                <li>Access to all group classes</li>
                                <li>Monthly 1-on-1 personal training session</li>
                                <li>Priority booking for popular classes</li>
                            <?php elseif ($membership === 'elite'): ?>
                                <li>Unlimited personal training sessions</li>
                                <li>Nutrition counseling</li>
                                <li>VIP lounge access</li>
                            <?php endif; ?>
                        </ul>
                    </section>
                <?php endif; ?>
            </section>
        </main>
    </div>
</body>
</html>
