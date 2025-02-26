<?php
include 'DBconfig.php';
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

$result = $conn->query("SELECT * FROM product_stock") or die($conn->error);
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
            <h2>Welcome Staff Dashboard</h2>
            <nav>
            <?php include 'nav.php'; ?>
            </nav>
        </aside>
        <main class="content">
            <div class="container">
                <h3>Product Stock Management</h3>

                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product ID</th>
                            <th>Quantity</th>
                            <th>Size</th>
                            <th>Flavor</th>
                            <th>Expiration Date</th>
                            <th>Description</th>
                            <th>Added At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['product_id']; ?></td>
                                <td><?php echo $row['quantity']; ?></td>
                                <td><?php echo $row['size']; ?></td>
                                <td><?php echo $row['flavor']; ?></td>
                                <td><?php echo $row['expiration_date']; ?></td>
                                <td><?php echo $row['description']; ?></td>
                                <td><?php echo $row['added_at']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>

</html>

<?php $conn->close(); ?>
