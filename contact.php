<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - FitZone Fitness Center</title>
    <link rel="stylesheet" href="contact-style.css">
</head>
<body>

<?php include 'header.html'; ?>

<?php session_start(); ?>
<section class="contact-section">
    <h1>Contact Us</h1>
    
    
    <?php if (isset($_SESSION['message'])): ?>
        <p class="<?php echo $_SESSION['message_type'] === 'success' ? 'success-message' : 'error-message'; ?>">
            <?php 
            echo $_SESSION['message']; 
            unset($_SESSION['message']); 
            unset($_SESSION['message_type']); 
            ?>
        </p>
    <?php endif; ?>

    <form action="contact-form.php" method="POST" class="contact-form">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>

        <label for="message">Message</label>
        <textarea id="message" name="message" rows="5" required></textarea>

        <button type="submit" class="btn primary-btn">Send Message</button>
    </form>
</section>



<?php include 'footer.html'; ?>
</body>
</html>
