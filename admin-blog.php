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


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = htmlspecialchars($_POST['title']);
    $content = htmlspecialchars($_POST['content']);
    
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $upload_dir = 'img/'; 
        $file_name = basename($_FILES['image']['name']);
        $target_file = $upload_dir . uniqid() . '-' . $file_name;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $stmt = $conn->prepare("INSERT INTO blog_posts (title, content, image_path) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $title, $content, $target_file);

            if ($stmt->execute()) {
                header('Location: blog.php');
                exit;
            } else {
                $error_message = "Error adding blog post: " . $conn->error;
            }
        } else {
            $error_message = "Failed to upload image.";
        }
    } else {
        $error_message = "No image uploaded or there was an error.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Blog Post - Admin Panel</title>
    <link rel="stylesheet" href="dashboard-styles.css">
</head>
<body>

<h3>Add New Blog Post</h3>
<?php if (isset($error_message)): ?>
    <p style="color:red;"><?php echo htmlspecialchars($error_message); ?></p>
<?php endif; ?>
<form method="POST" action="admin-blog.php" enctype="multipart/form-data">
    <label for="image">Image:</label>
    <input type="file" id="image" name="image" accept="image/*" required>
    
    <label for="title">Title:</label>
    <input type="text" id="title" name="title" required>
    
    <label for="content">Content:</label>
    <textarea id="content" name="content" required></textarea>
    
    <button type="submit">Add Post</button>
</form>

<a href="blog.php">Back to Blog</a>

            
        </main>
    </div>
</body>
</html>
