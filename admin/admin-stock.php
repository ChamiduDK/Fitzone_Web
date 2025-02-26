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
      <h3>Add Product Stock</h3>
      <form action="admin-stock.php" method="POST">
        <label for="product_id">Select Product:</label>
        <select name="product_id" required>
          <?php
          $result = $conn->query("SELECT id, name FROM products");
          while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
          }
          ?>
        </select>

        <label for="quantity">Stock Quantity:</label>
        <input type="number" name="quantity" required>

        <label for="size">Size:</label>
        <input type="text" name="size" placeholder="e.g., 1kg, 500ml">

        <label for="flavor">Flavor (if applicable):</label>
        <input type="text" name="flavor" placeholder="e.g., Chocolate, Vanilla">

        <label for="expiration_date">Expiration Date:</label>
        <input type="date" name="expiration_date">

        <label for="description">Description:</label>
        <textarea name="description" placeholder="Enter product description..."></textarea>

        <button type="submit" name="add_stock">Add Stock</button>
      </form>

      <?php
      // Handle stock addition
      if (isset($_POST['add_stock'])) {
        $product_id = $_POST['product_id'];
        $quantity = $_POST['quantity'];
        $size = $_POST['size'];
        $flavor = $_POST['flavor'];
        $expiration_date = $_POST['expiration_date'];
        $description = $_POST['description'];

        $stmt = $conn->prepare("INSERT INTO product_stock (product_id, quantity, size, flavor, expiration_date, description) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iissss", $product_id, $quantity, $size, $flavor, $expiration_date, $description);

        if ($stmt->execute()) {
          echo "<p>Stock added successfully!</p>";
        } else {
          echo "<p class='error'>Error: " . $stmt->error . "</p>";
        }

        $stmt->close();
      }

      $conn->close();
      ?>
    </main>
  </div>
</body>

</html>
