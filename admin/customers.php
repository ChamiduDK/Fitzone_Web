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
    <?php include 'nav.php';?>
    </aside>
    <main class="content">

      <?php
      
      if (isset($_GET['delete'])) {
          $id = $_GET['delete'];
          $conn->query("DELETE FROM customers WHERE id=$id") or die($conn->error);
          header("Location: customers.php");
      }

      
      if (isset($_POST['update'])) {
          $id = $_POST['id'];
          $name = $_POST['name'];
          $email = $_POST['email'];
          $address = $_POST['address'];

          $conn->query("UPDATE customers SET name='$name', email='$email', address='$address' WHERE id=$id") or die($conn->error);
          header("Location: customers.php");
      }

      
      $result = $conn->query("SELECT * FROM customers") or die($conn->error);
      ?>

      <div class="container">
        <h3>Customer Management</h3>

        <table class="styled-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Address</th>
              <th>Created At</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?php echo $row['id']; ?></td>
              <td><?php echo $row['name']; ?></td>
              <td><?php echo $row['email']; ?></td>
              <td><?php echo $row['address']; ?></td>
              <td><?php echo $row['created_at']; ?></td>
              <td>
                <a href="customers.php?edit=<?php echo $row['id']; ?>" class="btn btn-edit">Edit</a>
                <a href="customers.php?delete=<?php echo $row['id']; ?>" class="btn btn-delete" onclick="return confirm('Are you sure?')">Delete</a>
              </td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>

        <?php
        if (isset($_GET['edit'])) {
            $edit_id = $_GET['edit'];
            $edit_result = $conn->query("SELECT * FROM customers WHERE id=$edit_id") or die($conn->error);
            $edit_row = $edit_result->fetch_assoc();
        ?>
        <h3>Edit Customer</h3>
        <form action="customers.php" method="POST">
          <input type="hidden" name="id" value="<?php echo $edit_row['id']; ?>">
          <label for="name">Name:</label>
          <input type="text" name="name" value="<?php echo $edit_row['name']; ?>" required><br>

          <label for="email">Email:</label>
          <input type="email" name="email" value="<?php echo $edit_row['email']; ?>" required><br>

          <label for="address">Address:</label>
          <input type="text" name="address" value="<?php echo $edit_row['address']; ?>" required><br>

          <button type="submit" name="update" class="btn btn-edit">Update</button>
        </form>
        <?php
        }
        ?>

      </div>

    </main>
  </div>
</body>

</html>

<?php 
$conn->close(); 
?>
