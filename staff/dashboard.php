<?php
session_start();
include 'DBconfig.php';
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

$result = $conn->query("SELECT o.id, o.name, o.price, o.quantity, o.total, o.payment_method, o.created_at, c.name AS customer_name 
                         FROM orders o 
                         JOIN customers c ON o.customer_id = c.id") or die($conn->error);

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
      <h2>Welcome Staff Dashboard</h2>
      <nav>

        <?php include 'nav.php'; ?>

      </nav>
    </aside>
    <main class="content">

      <div class="container">
        <h3>Orders </h3>

        <!-- Table displaying the order data -->
        <table class="styled-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Customer Name</th>
              <th>Product Name</th>
              <th>Price</th>
              <th>Quantity</th>
              <th>Total</th>
              <th>Payment Method</th>
              <th>Created At</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?php echo $row['id']; ?></td>
              <td><?php echo $row['customer_name']; ?></td>
              <td><?php echo $row['name']; ?></td>
              <td><?php echo number_format($row['price'], 2); ?></td>
              <td><?php echo $row['quantity']; ?></td>
              <td><?php echo number_format($row['total'], 2); ?></td>
              <td><?php echo $row['payment_method']; ?></td>
              <td><?php echo $row['created_at']; ?></td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </main>
  </div>
</body>

</html>