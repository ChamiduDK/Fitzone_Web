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
            <h2>Welcome, Admin</h2>
            <nav>
                <a href="admin/dashboard.php">Dashboard</a>
                <h2>Manage Users</h2>
                <a href="admin/users.php">Members</a>
                <a href="admin/customers.php">Customers</a>
                <a href="admin/add-staff.php">Staff</a>
                <a href="admin/add-coach.php">Coaches</a>
                <h2>Manage Order</h2>
                <a href="admin/orders.php">Order Table</a>
                <h2>Manage Products</h2>
                <a href="admin/admin-product.php">Add Products</a>
                <a href="admin/admin-stock.php">Add Product Stock</a>
                <a href="admin/products.php">Product Table</a>
                <h2>Manage Stock</h2>
                <a href="admin/product-stock.php">Stock Table</a>
                <a href="admin/admin-stock.php">Add Stock</a>
                <h2>Manage Gallery Page</h2>
                <a href="admin/admin-gallery.php">Add New Image</a>
                <a href="admin/gallery.php">Image Table</a>
                <h2>Manage Blog Page</h2>
                <a href="admin-blog.php">Add New Blog Post</a>
                <a href="blog-posts.php">Blog Post Table</a>
                <a href="admin/logout.php">Log Out</a>
            </nav>
        </aside>

        <main class="content">

            <?php
            // Handle delete request
            if (isset($_GET['delete'])) {
                $id = $_GET['delete'];
                $stmt = $conn->prepare("DELETE FROM blog_posts WHERE id = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $stmt->close();
                header("Location: blog_posts.php");
            }

            // Handle edit request
            if (isset($_POST['update'])) {
                $id = $_POST['id'];
                $title = $_POST['title'];
                $content = $_POST['content'];

                // Sanitize input to prevent SQL Injection
                $title = htmlspecialchars($title, ENT_QUOTES);
                $content = htmlspecialchars($content, ENT_QUOTES);

                $stmt = $conn->prepare("UPDATE blog_posts SET title = ?, content = ? WHERE id = ?");
                $stmt->bind_param("ssi", $title, $content, $id);
                $stmt->execute();
                $stmt->close();
                header("Location: blog_posts.php");
            }

            // Fetch blog posts data
            $result = $conn->query("SELECT * FROM blog_posts") or die($conn->error);
            ?>

            <!-- <div class="container"> -->
                <h3>Blog Posts Management</h3>

                <!-- Table displaying blog posts -->
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Content</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><img src="<?php echo $row['image_path']; ?>" alt="<?php echo $row['title']; ?>" width="100"></td>
                            <td><?php echo $row['title']; ?></td>
                            <td><?php echo substr($row['content'], 0, 50) . '...'; ?></td>
                            <td><?php echo $row['created_at']; ?></td>
                            <td>
                                <!-- Edit Button to Load Data in Form -->
                                <a href="blog_posts.php?edit=<?php echo $row['id']; ?>" class="btn btn-edit">Edit</a>
                                <a href="blog_posts.php?delete=<?php echo $row['id']; ?>" class="btn btn-delete" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

                <!-- Form to Edit Blog Post -->
                <?php
                if (isset($_GET['edit'])) {
                    $edit_id = $_GET['edit'];
                    $edit_result = $conn->query("SELECT * FROM blog_posts WHERE id = $edit_id") or die($conn->error);
                    $edit_row = $edit_result->fetch_assoc();
                ?>
                <h3>Edit Blog Post</h3>
                <form action="blog_posts.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $edit_row['id']; ?>">
                    <label for="title">Title:</label>
                    <input type="text" name="title" value="<?php echo $edit_row['title']; ?>" required>
                    <label for="content">Content:</label>
                    <textarea name="content" rows="4" required><?php echo $edit_row['content']; ?></textarea>
                    <button type="submit" name="update" class="btn btn-save">Update</button>
                </form>
                <?php } ?>

            </div>

        </main>
    </div>
</body>

</html>

<?php
$conn->close(); // Close the database connection at the end of the script
?>
