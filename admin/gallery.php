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
        // Handle delete request
        if (isset($_GET['delete'])) {
            $id = $_GET['delete'];
            $conn->query("DELETE FROM gallery WHERE id=$id") or die($conn->error);
            header("Location: gallery.php");
        }

        // Handle edit request
        if (isset($_POST['update'])) {
            $id = $_POST['id'];
            $image_name = $_POST['image_name'];
            $description = $_POST['description'];
            
            $conn->query("UPDATE gallery SET image_name='$image_name', description='$description' WHERE id=$id") or die($conn->error);
            header("Location: gallery.php");
        }

        // Fetch gallery data
        $result = $conn->query("SELECT * FROM gallery") or die($conn->error);
      ?>

      <div class="container">
        <h3>Gallery Management</h3>

        <table class="styled-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Image</th>
              <th>Image Name</th>
              <th>Description</th>
              <th>Uploaded At</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?php echo $row['id']; ?></td>
              <td><img src="<?php echo $row['image_path']; ?>" alt="<?php echo $row['image_name']; ?>" width="100"></td>
              <td><?php echo $row['image_name']; ?></td>
              <td><?php echo $row['description']; ?></td>
              <td><?php echo $row['uploaded_at']; ?></td>
              <td>
                <!-- Trigger the form for editing -->
                <a href="gallery.php?edit=<?php echo $row['id']; ?>" class="btn btn-edit">Edit</a>
                <a href="gallery.php?delete=<?php echo $row['id']; ?>" class="btn btn-delete" onclick="return confirm('Are you sure?')">Delete</a>
              </td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>

        <?php
        // Show update form if the 'edit' parameter is set
        if (isset($_GET['edit'])) {
            $edit_id = $_GET['edit'];
            $edit_result = $conn->query("SELECT * FROM gallery WHERE id = $edit_id") or die($conn->error);
            $edit_row = $edit_result->fetch_assoc();
        ?>
          <h4>Edit Gallery Image</h4>
          <form action="gallery.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $edit_row['id']; ?>">
            <label for="image_name">Image Name:</label>
            <input type="text" name="image_name" value="<?php echo $edit_row['image_name']; ?>" required>

            <label for="description">Description:</label>
            <input type="text" name="description" value="<?php echo $edit_row['description']; ?>" required>

            <button type="submit" name="update" class="btn btn-save">Save Changes</button>
          </form>
        <?php } ?>
      </div>

    </main>
  </div>

  <?php $conn->close(); ?>
</body>

</html>
