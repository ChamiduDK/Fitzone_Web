<?php
include 'DBconfig.php';
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Staff Dashboard</title>
  <link rel="stylesheet" href="dashboard-styles.css">
</head>
<body>
  <div class="dashboard-container">
    <aside class="sidebar">
      <h2>Welcome, Staff Dashboard</h2>
      <nav>
      <?php include 'nav.php'; ?>
      </nav>
    </aside>
    <main class="content">
      <?php
      // Handle delete request
      if (isset($_GET['delete'])) {
          $id = $_GET['delete'];
          $conn->query("DELETE FROM user WHERE id=$id") or die($conn->error);
          header("Location: users.php");
      }

      // Handle edit request
      if (isset($_POST['update'])) {
          $id = $_POST['id'];
          $username = $_POST['username'];
          $email = $_POST['email'];
          $phone = $_POST['phone'];
          $address = $_POST['address'];
          $membership = $_POST['membership'];
          
          $conn->query("UPDATE user SET username='$username', email='$email', phone='$phone', address='$address', membership='$membership' WHERE id=$id") or die($conn->error);
          header("Location: users.php");
      }

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
            <!-- <th>Created At</th> -->
            <th>Actions</th>
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
            <!-- <td><?php echo htmlspecialchars($row['created_at']); ?></td> -->
            <td>
              <a href="users.php?edit=<?php echo $row['id']; ?>" class="btn btn-edit">Edit</a>
              <a href="users.php?delete=<?php echo $row['id']; ?>" class="btn btn-delete" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>

      <?php
      // Fetch data for the selected user to edit
      if (isset($_GET['edit'])) {
          $id = $_GET['edit'];
          $edit_result = $conn->query("SELECT * FROM user WHERE id=$id") or die($conn->error);
          $row = $edit_result->fetch_assoc();
      ?>
      <h3>Update User</h3>
      <form action="users.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <label for="username">Username:</label>
        <input type="text" name="username" value="<?php echo htmlspecialchars($row['username']); ?>" required>
        
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required>
        
        <label for="phone">Phone:</label>
        <input type="text" name="phone" value="<?php echo htmlspecialchars($row['phone']); ?>" required>
        
        <label for="address">Address:</label>
        <input type="text" name="address" value="<?php echo htmlspecialchars($row['address']); ?>" required>
        
        <label for="membership">Membership:</label>
        <select name="membership" required>
          <option value="basic" <?php if ($row['membership'] == 'basic') echo 'selected'; ?>>Basic</option>
          <option value="premium" <?php if ($row['membership'] == 'premium') echo 'selected'; ?>>Premium</option>
          <option value="elite" <?php if ($row['membership'] == 'elite') echo 'selected'; ?>>Elite</option>
        </select>

        <button type="submit" name="update" class="btn btn-edit">Update</button>
      </form>
      <?php } ?>

      <?php $conn->close(); ?>
    </main>
  </div>
</body>
</html>
