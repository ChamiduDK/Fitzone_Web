<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['user_id'];
include 'DBconfig.php';
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
    <h2>Welcome Coach Dashboard</h2>
      <nav>

        <a href="dashboard.php">Dashboard</a>
        <a href="users.php">Members</a>
        <a href="appointments.php">Appointments</a>

        <a href="logout.php">Log Out</a>

      </nav>
    </aside>
    <main class="content">
      <?php

      // Fetch users
      $result = $conn->query("SELECT * FROM user") or die($conn->error);
      ?>

      <h3>User Management</h3>
      <table class="styled-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Membership</th>

          </tr>
        </thead>
        <tbody>
          <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['username']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo htmlspecialchars($row['phone']); ?></td>
            <td><?php echo htmlspecialchars($row['address']); ?></td>
            <td><?php echo htmlspecialchars($row['membership']); ?></td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>


      <?php $conn->close(); ?>
    </main>
  </div>
</body>
</html>
