<?php
include 'DBconfig.php';
session_start();

// Fetch user ID from session
$user_id = $_SESSION["user_id"];

$stmt = $conn->prepare("SELECT membership FROM user WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($membership);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membership</title>
    <link rel="stylesheet" href="dashboard-styles.css">
</head>
<body>
    <div class="dashboard-container">
        <?php include 'sidebar.php'; ?>
        <main class="content">
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
        </main>
    </div>
</body>
</html>
