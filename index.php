<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FitZone Fitness Center</title>
  <link rel="stylesheet" href="index-style.css">

</head>

<body>

  <?php include 'header.html'; ?>

  <section class="hero">
  <div class="overlay">
    <h1>FORGING THE LEGENDS OF TOMORROW</h1>
    <p class="tagline">Train harder, grow stronger, live better.</p>
  </div>
</section>

  <section class="intro-section">
    <div class="intro-content">
      <h1>Welcome to FitZone Fitness Center</h1>
      <p>Your Ultimate Fitness Destination in Kurunegala. At FitZone, we offer a wide range of fitness programs,
        state-of-the-art equipment, and expert guidance to support you in every step of your fitness journey.</p>
      <ul class="features-list">
        <li> Wide Range of Fitness Programs: Cardio, Strength Training, Yoga, and more.</li>
        <li> State-of-the-Art Equipment to enhance your workout experience.</li>
        <li> Personalized Training Sessions with certified trainers.</li>
        <li> Group Classes for a fun, community-focused workout environment.</li>
        <li> Nutrition Counseling to complement your fitness goals.</li>
      </ul>
      <a href="about.php" class="btn primary-btn">Learn More</a>
    </div>

    <div class="intro-image">
      <?php
           echo '<img src="img/3.jpg">';
        ?>
    </div>
  </section>

  <?php include 'workout-plan.html'; ?>

  <section class="membership-section">
    <h2 id="section02">Membership Options</h2>
    <div class="membership-content">

      <div class="membership-card">

        <div class="card-content">
          <h3>Basic Membership</h3>
          <ul class="benefits-list">
            <li>Access to all gym facilities</li>
            <li>Cardio and strength training areas</li>
            <li>Locker room and shower access</li>
            <li>Free Wi-Fi access</li>
            <li>One free fitness assessment per month</li>
          </ul>
          <br><br><br><br><br><br><br><br>

          <p class="price">Starting at <br> LKR 5,000.00/month</p>
          <a href="member/signup.php" class="btn secondary-btn">Join</a>
        </div>
      </div>


      <div class="membership-card">

        <div class="card-content">
          <h3>Premium Membership</h3>
          <ul class="benefits-list">
            <li>All Basic benefits</li>
            <li>Access to all group classes</li>
            <li>Monthly 1-on-1 personal training session</li>
            <li>Access to exclusive workout equipment</li>
            <li>Priority booking for popular classes</li>
            <li>Discounts on supplements and merchandise</li>
            <li>Special access to monthly workshops and seminars</li>
          </ul>
          <br><br>
          <p class="price">Starting at <br> LKR 10,000.00/month</p>
          <a href="member/signup.php" class="btn secondary-btn">Join</a>
        </div>
      </div>


      <div class="membership-card">

        <div class="card-content">
          <h3>Elite <br> Membership</h3>
          <ul class="benefits-list">
            <li>All Premium benefits</li>
            <li>Unlimited personal training sessions</li>
            <li>Nutrition counseling and meal planning</li>
            <li>Access to spa facilities and sauna</li>
            <li>Priority access to trainers and facilities</li>
            <li>Customized workout and nutrition plans</li>
            <li>Free entry to exclusive fitness events</li>
            <li>Dedicated VIP lounge access</li>
          </ul>
          <p class="price">Starting at <br> LKR 15,000.00/month</p>
          <a href="member/signup.php" class="btn secondary-btn">Join</a>
        </div>
      </div>
    </div>
  </section>

  <?php
require 'DBconfig.php';

$result = $conn->query("SELECT id, title, content, image_path FROM blog_posts ORDER BY created_at DESC LIMIT 4");

if (!$result) {
    die("Error retrieving blog posts: " . $conn->error);
}
?>

  <section class="blog-section">
    <h2>FitZone Blog</h2>

    <div class="blog-grid">
      <?php if ($result->num_rows > 0): ?>
      <?php while ($post = $result->fetch_assoc()): ?>
      <article class="blog-card">
        <img src="<?php echo htmlspecialchars($post['image_path']); ?>"
          alt="<?php echo htmlspecialchars($post['title']); ?>">
        <div class="blog-content">
          <h3><?php echo htmlspecialchars($post['title']); ?></h3>
          <p><?php echo htmlspecialchars(substr($post['content'], 0, 100)); ?>...</p>
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