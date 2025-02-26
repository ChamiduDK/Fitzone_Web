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
      <h3>Add New Gallery Image</h3>
      <form action="admin-gallery.php" method="POST" enctype="multipart/form-data">
        <label for="image">Gallery Image:</label>
        <input type="file" name="image" accept="image/*" required>

        <label for="description">Description:</label>
        <textarea name="description" placeholder="Enter image description..."></textarea>

        <button type="submit" name="add_gallery_image">Add Image</button>
      </form>

      <?php
      if (isset($_POST['add_gallery_image'])) {
          $description = $_POST['description'];
          $image = $_FILES['image']['name'];
          $target = "../gallery/" . basename($image); // Ensure the directory exists and is writable

          // Prepare the insert statement
          $stmt = $conn->prepare("INSERT INTO gallery (image_name, image_path, description) VALUES (?, ?, ?)");
          $stmt->bind_param("sss", $image, $target, $description);

          if ($stmt->execute()) {
              // Attempt to upload the file
              if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                  echo "<p>Image added successfully!</p>";
              } else {
                  echo "<p class='error'>Failed to upload image.</p>";
              }
          } else {
              echo "<p class='error'>Error: " . $stmt->error . "</p>";
          }

          // Close statement and connection
          $stmt->close();
      }

      $conn->close();
      ?>
    </main>
  </div>
</body>

</html>
