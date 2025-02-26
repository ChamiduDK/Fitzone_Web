<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FitZone Classes</title>
  <link rel="stylesheet" href="classes-style.css">


</head>

<body>

  <?php include 'header.html'; ?>

  <section class="classes-hero">
    <h1>Our Fitness Classes</h1>
  </section>

  <section class="classes-grid">
    <div class="class-card">
      <img src="img/9.jpg" alt="Cardio Class">
      <h3>Cardio</h3>
      <p>Boost your heart health and burn calories with our intense cardio sessions.</p>
    </div>
    <div class="class-card">
      <img src="img/10.jpg" alt="Yoga Class">
      <h3>Yoga</h3>
      <p>Find your balance and improve flexibility with our expert-led yoga classes.</p>
    </div>
    <div class="class-card">
      <img src="img/11.jpg" alt="Strength Class">
      <h3>Strength Training</h3>
      <p>Build muscle and tone your body with our strength-focused workouts.</p>
    </div>
    <div class="class-card">
      <img src="img/12.jpg" alt="Zumba Class">
      <h3>Zumba</h3>
      <p>Dance your way to fitness with our high-energy Zumba classes.</p>
    </div>
  </section>

  <section class="appointment-section">
    <style>
    .appointment-section {
      padding: 50px;
      text-align: center;
    }

    .appointment-form {
      max-width: 400px;
      margin: 0 auto;
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .appointment-form label {
      display: block;
      margin: 10px 0 5px;
    }

    .appointment-form input,
    .appointment-form select,
    .appointment-form button {
      width: 100%;
      padding: 10px;
      margin: 5px 0;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    .appointment-form button {
      background-color: #e60000;
      color: #fff;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .appointment-form button:hover {
      background-color: #333;
    }
    </style>
    <h2>Make an Appointment</h2><br>
    <form action="classes.php" method="POST" class="appointment-form">
      <label for="class_name">Choose a Class:</label>
      <select id="class_name" name="class_name" required>
        <option value="Cardio">Cardio</option>
        <option value="Yoga">Yoga</option>
        <option value="Strength Training">Strength Training</option>
        <option value="Zumba">Zumba</option>
      </select>

      <label for="name">Name:</label>
      <input type="text" id="name" name="name" required>

      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required>

      <label for="date">Preferred Date:</label>
      <input type="date" id="date" name="date" required>

      <button type="submit">Book Appointment</button>

      <?php
include 'DBconfig.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $class_name = $_POST['class_name'];
    $appointment_date = $_POST['date'];

    $sql = "INSERT INTO appointments (name, email, class_name, appointment_date) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $email, $class_name, $appointment_date);

    if ($stmt->execute()) {
      echo "<p>Appointment successfully booked for $class_name on $appointment_date!</p>";
  } else {
      echo "<p>There was an error booking your appointment. Please try again.</p>";
  }

    
    $stmt->close();
    $conn->close();
}
?>


    </form>
  </section>

  <?php include 'footer.html'; ?>
</body>

</html>