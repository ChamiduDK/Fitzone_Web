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
  <title>Member Dashboard</title>
  <link rel="stylesheet" href="dashboard-styles.css">
</head>

<body>
  <div class="dashboard-container">
    <aside class="sidebar">
      <h2>Welcome Staff Dashboard </h2>
      <nav>
      <?php include 'nav.php'; ?>
      </nav>
    </aside>
    <main class="content">

      <h3>Add New Product</h3>
      <form action="add-product.php" method="POST" enctype="multipart/form-data">
        <label for="name">Product Name:</label>
        <input type="text" name="name" required>

        <label for="price">Price (Rs.):</label>
        <input type="number" name="price" step="0.01" required>

        <label for="image">Product Image:</label>
        <input type="file" name="image" accept="image/*" required>

        <label for="category">Category:</label>
        <select name="category" required>
          <option value="Accessories">Accessories</option>
          <option value="Creatine">Creatine</option>
          <option value="Pre-Workout">Pre-Workout</option>
          <option value="Protein">Protein</option>
          <option value="Vitamins & Wellness">Vitamins & Wellness</option>
          <option value="Weight Gainers">Weight Gainers</option>
        </select>

        <button type="submit" name="add_product">Add Product</button>
      </form>

      <?php
      // Handle product addition
      if (isset($_POST['add_product'])) {
          $name = $_POST['name'];
          $price = $_POST['price'];
          $category = $_POST['category'];
          $image = $_FILES['image']['name'];
          $target = "../shop/uploads/" . basename($image);

          // Check for file upload errors
          if ($_FILES['image']['error'] != 0) {
              echo "<p class='error'>File upload error. Please try again.</p>";
          } else {
              // Check for valid image file type
              $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
              if (!in_array($_FILES['image']['type'], $allowedTypes)) {
                  echo "<p class='error'>Invalid image type. Only JPG, PNG, and GIF are allowed.</p>";
              } else {
                  // Prepare and bind the SQL statement
                  $stmt = $conn->prepare("INSERT INTO products (name, price, image, category) VALUES (?, ?, ?, ?)");
                  $stmt->bind_param("sdss", $name, $price, $image, $category);

                  if ($stmt->execute()) {
                      // Attempt to move the uploaded image file
                      if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                          echo "<p>Product added successfully!</p>";
                      } else {
                          echo "<p class='error'>Failed to upload image.</p>";
                      }
                  } else {
                      echo "<p class='error'>Error: " . $stmt->error . "</p>";
                  }

                  $stmt->close();
              }
          }
      }
      ?>
    </main>
  </div>
</body>

</html>
