<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitZone Gallery</title>
    <link rel="stylesheet" href="gallery-style.css">
</head>
<body>



<?php include 'header.html'; ?>

<section class="gallery-hero">
    <h1>Our Gallery</h1>
</section>

<section class="gallery-grid">
    <?php
    include 'DBconfig.php';
    $result = $conn->query("SELECT * FROM gallery");

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="gallery-item">';
            echo '<img src="' . $row['image_path'] . '" alt="Gallery Image">';
            echo '<p>' . htmlspecialchars($row['description']) . '</p>';
            echo '</div>';
        }
    } else {
        echo "<p>No images in the gallery yet.</p>";
    }

    $conn->close();
    ?>
</section>


<?php include 'footer.html'; ?>

</body>
</html>
