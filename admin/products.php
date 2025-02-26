<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['user_id'];
include 'DBconfig.php';

$product_to_edit = null;

// Handle edit request
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = $conn->query("SELECT * FROM products WHERE id=$id") or die($conn->error);
    $product_to_edit = $result->fetch_assoc();
}

// Handle update request
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_POST['image'];
    $category = $_POST['category'];

    $conn->query("UPDATE products SET name='$name', price='$price', image='$image', category='$category' WHERE id=$id") or die($conn->error);
    header("Location: products.php");
}

// Handle delete request
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM products WHERE id=$id") or die($conn->error);
    header("Location: products.php");
}

// Fetch products
$result = $conn->query("SELECT * FROM products") or die($conn->error);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product Management</title>
  <link rel="stylesheet" href="dashboard-styles.css">
</head>

<body>
  <div class="dashboard-container">
    <aside class="sidebar">
    <?php include 'nav.php';?>
    </aside>
    <main class="content">
      <div class="container">
        <h3>Product Management</h3>

        <table class="styled-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Price</th>
              <th>Image URL</th>
              <th>Category</th>
              <th>Created At</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?php echo $row['id']; ?></td>
              <td><?php echo htmlspecialchars($row['name']); ?></td>
              <td><?php echo htmlspecialchars($row['price']); ?></td>
              <td><?php echo htmlspecialchars($row['image']); ?></td>
              <td><?php echo htmlspecialchars($row['category']); ?></td>
              <td><?php echo $row['created_at']; ?></td>
              <td>
                <a href="products.php?edit=<?php echo $row['id']; ?>" class="btn btn-edit">Edit</a>
                <a href="products.php?delete=<?php echo $row['id']; ?>" class="btn btn-delete"
                  onclick="return confirm('Are you sure?')">Delete</a>
              </td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>

        <!-- Edit Form -->
        <?php if ($product_to_edit): ?>
        <div class="edit-form">
          <h3>Edit Product</h3>
          <form action="products.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $product_to_edit['id']; ?>">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($product_to_edit['name']); ?>" required>

            <label for="price">Price:</label>
            <input type="text" name="price" id="price" value="<?php echo htmlspecialchars($product_to_edit['price']); ?>" required>

            <label for="image">Image URL:</label>
            <input type="text" name="image" id="image" value="<?php echo htmlspecialchars($product_to_edit['image']); ?>" required>

            <label for="category">Category:</label>
            <input type="text" name="category" id="category" value="<?php echo htmlspecialchars($product_to_edit['category']); ?>" required>

            <button type="submit" name="update" class="btn btn-save">Save Changes</button>
          </form>
        </div>
        <?php endif; ?>

      </div>

      <?php $conn->close(); ?>
    </main>
  </div>
</body>

</html>
