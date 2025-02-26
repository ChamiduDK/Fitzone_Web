<?php
session_start();
require 'DBconfig.php';

// Retrieve blog posts from the database
$result = $conn->query("SELECT id, title, content, image_path FROM blog_posts ORDER BY created_at DESC");

if (!$result) {
    die("Error retrieving blog posts: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitZone Blog</title>
    <link rel="stylesheet" href="style.css">
</head>
<?php include 'header.html'; ?>
<body>
<section class="blog-section">
    <h2>FitZone Blog</h2>

    <div class="blog-grid">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($post = $result->fetch_assoc()): ?>
                <article class="blog-card">
                    <img src="<?php echo htmlspecialchars($post['image_path']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>">
                    <div class="blog-content">
                        <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                        <p><?php echo htmlspecialchars(substr($post['content'], 0, 200)); ?>...</p>
                        <a href="post.php?post_id=<?php echo $post['id']; ?>" class="read-more">Read More</a>
                    </div>
                </article>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No blog posts available.</p>
        <?php endif; ?>
    </div>
</section>
</body>
<?php include 'footer.html'; ?>
</html>
