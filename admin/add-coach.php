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
    <?php include 'nav.php';?>
    </aside>

    <main class="content">
      <h3>Add Gym Coach</h3>
      <form method="POST" action="">
          <label for="name">Name:</label>
          <input type="text" id="name" name="name" required><br>

          <label for="specialization">Specialization:</label>
          <input type="text" id="specialization" name="specialization" required><br>

          <label for="email">Email:</label>
          <input type="email" id="email" name="email" required><br>

          <label for="phone">Phone:</label>
          <input type="text" id="phone" name="phone" required><br>

          <label for="password">Password:</label>
          <input type="password" id="password" name="password" required><br>

          <button type="submit">Add Coach</button>
      </form>

      <?php
      // Process form data for adding a coach
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          // Get form inputs
          $name = $_POST['name'];
          $specialization = $_POST['specialization'];
          $email = $_POST['email'];
          $phone = $_POST['phone'];
          $password = $_POST['password']; // Plain text password

          // SQL query to insert coach details
          $query = "INSERT INTO Coaches (name, specialization, email, phone, password) VALUES (?, ?, ?, ?, ?)";
          $stmt = $conn->prepare($query);

          if ($stmt) {
              // Bind parameters
              $stmt->bind_param("sssss", $name, $specialization, $email, $phone, $password);

              // Execute the statement and check for success
              if ($stmt->execute()) {
                  echo "<p>Coach added successfully!</p>";
              } else {
                  echo "<p class='error'>Error: " . htmlspecialchars($stmt->error) . "</p>";
              }

              // Close the prepared statement
              $stmt->close();
          } else {
              echo "<p class='error'>Error preparing statement: " . htmlspecialchars($conn->error) . "</p>";
          }

          // Close the connection
          $conn->close();
      }
      ?>
    </main>
  </div>
</body>

</html>
