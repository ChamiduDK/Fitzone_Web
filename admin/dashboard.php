<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
$username = $_SESSION['user_id'];

include 'DBconfig.php';

// Fetch staff data
$staff_sql = "SELECT * FROM Staff";
$staff_result = $conn->query($staff_sql);

// Fetch coaches data
$coaches_sql = "SELECT * FROM Coaches";
$coaches_result = $conn->query($coaches_sql);
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
      <?php include 'nav.php'; ?>
    </aside>
    <main class="content">

      <!-- Staff Table -->
      <h3>Staff Table</h3>
      <table class="styled-table">
        <thead>
          <tr>
            <th>Staff ID</th>
            <th>Name</th>
            <th>Role</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($staff_result->num_rows > 0) {
              while ($row = $staff_result->fetch_assoc()) {
                  echo "<tr>
                          <td>{$row['staff_id']}</td>
                          <td>{$row['name']}</td>
                          <td>{$row['role']}</td>
                          <td>{$row['email']}</td>
                          <td>{$row['phone']}</td>
                          <td class='action-buttons'>
                            <a href='edit_staff.php?id={$row['staff_id']}' class='edit-btn'>Edit</a>
                            <a href='delete_staff.php?id={$row['staff_id']}' class='delete-btn' onclick='return confirm(\"Are you sure?\");'>Delete</a>
                          </td>
                        </tr>";
              }
          } else {
              echo "<tr><td colspan='6'>No records found</td></tr>";
          }
          ?>
        </tbody>
      </table>

      <!-- Coaches Table -->
      <h3>Coaches Table</h3>
      <table class="styled-table">
        <thead>
          <tr>
            <th>Coach ID</th>
            <th>Name</th>
            <th>Specialization</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($coaches_result->num_rows > 0) {
              while ($row = $coaches_result->fetch_assoc()) {
                  echo "<tr>
                          <td>{$row['coach_id']}</td>
                          <td>{$row['name']}</td>
                          <td>{$row['specialization']}</td>
                          <td>{$row['email']}</td>
                          <td>{$row['phone']}</td>
                          <td class='action-buttons'>
                            <a href='edit_coach.php?id={$row['coach_id']}' class='edit-btn'>Edit</a>
                            <a href='delete_coach.php?id={$row['coach_id']}' class='delete-btn' onclick='return confirm(\"Are you sure?\");'>Delete</a>
                          </td>
                        </tr>";
              }
          } else {
              echo "<tr><td colspan='6'>No records found</td></tr>";
          }
          ?>
        </tbody>
      </table>

    </main>
  </div>
</body>
</html>
