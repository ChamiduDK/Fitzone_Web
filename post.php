<?php
session_start();
require 'DBconfig.php';

// Validate and retrieve the post ID
$post_id = isset($_GET['post_id']) ? (int)$_GET['post_id'] : 0;

if ($post_id < 1) {
    echo "Invalid blog post ID.";
    exit;
}

// Retrieve the specific blog post
$stmt = $conn->prepare("SELECT title, content, image_path FROM blog_posts WHERE id = ?");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Blog post not found.";
    exit;
}

$post = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($post['title']); ?></title>
    <link rel="stylesheet" href="post-style.css">
</head>
<body>

<section class="blog-post">
    <h2><?php echo htmlspecialchars($post['title']); ?></h2>
    <img src="<?php echo htmlspecialchars($post['image_path']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>">
    <p><?php echo htmlspecialchars($post['content']); ?></p>    
    <a href="blog.php" class="back-link">Back to Blog</a>
</section>

</body>
</html>
