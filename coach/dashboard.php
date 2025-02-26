<?php
include 'DBconfig.php';
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
$coach_id = $_SESSION['user_id']; 

$sql = "SELECT * FROM user_health";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Member Dashboard</title>
  <link rel="stylesheet" href="dashboard-styles.css">
  <style>
  body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    color: #333;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding-top: 20px;
  }

  .user-health-card {
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    margin: 20px;
    width: 80%;
    max-width: 600px;
  }

  .user-health-card h3 {
    color: #007bff;
    margin-bottom: 10px;
    font-size: 1.5em;
  }

  .user-health-card p {
    margin: 5px 0;
    line-height: 1.6;
  }

  .user-health-card .section-title {
    font-weight: bold;
    margin-top: 15px;
    color: #333;
  }
  </style>
</head>

<body>
  <div class="dashboard-container">
    <aside class="sidebar">
      <h2>Welcome Coach Dashboard</h2>
      <nav>

        <a href="dashboard.php">Dashboard</a>
        <a href="users.php">Members</a>
        <a href="appointments.php">Appointments</a>

        <a href="logout.php">Log Out</a>

      </nav>
    </aside>
    <main class="content">

      <h3>User Health Information</h3>

      <?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='user-health-card'>";
        echo "<h3>User ID: " . $row['user_id'] . "</h3>";
        echo "<p><span class='section-title'>Primary Goal:</span> " . $row['primary_goal'] . "</p>";
        echo "<p><span class='section-title'>Secondary Goals:</span> " . $row['secondary_goals'] . "</p>";
        echo "<p><span class='section-title'>Experience Level:</span> " . $row['experience_level'] . "</p>";
        echo "<p><span class='section-title'>Medical Conditions:</span> " . $row['medical_conditions'] . "</p>";
        echo "<p><span class='section-title'>Fitness Assessment:</span> " . $row['fitness_assessment'] . "</p>";
        echo "<p><span class='section-title'>Mobility Issues:</span> " . $row['mobility_issues'] . "</p>";
        echo "<p><span class='section-title'>Mobility Flexibility:</span> " . $row['mobility_flexibility'] . "</p>";
        echo "<p><span class='section-title'>Time Commitment (mins):</span> " . $row['time_commitment'] . "</p>";
        echo "<p><span class='section-title'>Activity Level:</span> " . $row['activity_level'] . "</p>";
        echo "<p><span class='section-title'>Cardio Preference:</span> " . $row['cardio_preference'] . "</p>";
        echo "<p><span class='section-title'>Strength Preference:</span> " . $row['strength_preference'] . "</p>";
        echo "<p><span class='section-title'>Workout Environment:</span> " . $row['workout_environment'] . "</p>";
        echo "<p><span class='section-title'>Diet Preference:</span> " . $row['diet_preference'] . "</p>";
        echo "<p><span class='section-title'>Daily Water Intake (ml):</span> " . $row['daily_water_intake'] . "</p>";
        echo "</div>";
    }
} else {
    echo "<p>No user health data found.</p>";
}

$conn->close();
?>


    </main>
  </div>
</body>

</html>