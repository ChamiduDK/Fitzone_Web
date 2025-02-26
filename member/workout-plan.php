<?php
include 'DBconfig.php';
session_start();

// Fetch user ID from session
$user_id = $_SESSION["user_id"];

$stmt = $conn->prepare("SELECT username, email, phone, address, membership FROM user WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username, $email, $phone, $address, $membership);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Member Dashboard</title>
  <link rel="stylesheet" href="dashboard-styles.css">
  <style>
    

    form {
      background: #fff;
      padding: 20px 30px;
      border-radius: 8px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
      max-width: 750px;
      width: 100%;
    }

    h1 {
      text-align: center;
      margin-bottom: 20px;
      font-size: 1.5em;
      color: #333;
    }

    label {
      font-size: 0.9em;
      color: #555;
    }

    input[type="text"],
    input[type="number"],
    select,
    textarea {
      width: 100%;
      padding: 10px;
      margin: 8px 0 15px 0;
      border: 1px solid #ddd;
      border-radius: 4px;
      font-size: 1em;
    }

    select,
    textarea {
      resize: vertical;
    }

    button[type="submit"] {
      width: 100%;
      padding: 12px;
      font-size: 1em;
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button[type="submit"]:hover {
      background-color: #0056b3;
    }

    /* Responsive Design */
    @media (max-width: 500px) {
      form {
        padding: 15px;
      }

      h1 {
        font-size: 1.2em;
      }

      button[type="submit"] {
        padding: 10px;
        font-size: 0.9em;
      }
    }
</style>
</head>

<body>
  <div class="dashboard-container">
    <aside class="sidebar">
      <h2>Welcome, <?php echo htmlspecialchars($username); ?></h2>
      <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="workout-plan.php">Workout Plan</a>
        <a href="profile.php">Profile</a>
        <a href="membership.php">Membership</a>
        <a href="settings.php">Settings</a>
        <a href="logout.php">Log Out</a>
      </nav>
    </aside>
    <main class="content">

      <form action="submit_user_health.php" method="POST">
        <h1>Workout Plan Form</h1>
        <label for="primary_goal">Primary Goal:</label>
        <select name="primary_goal" required>
          <option value="muscle">Build Muscle</option>
          <option value="weight_loss">Lose Weight</option>
          <option value="endurance">Increase Endurance</option>
          <option value="strength">Improve Strength</option>
          <option value="fitness">Stay Fit</option>
          <option value="flexibility">Improve Flexibility</option>
        </select>

        <label for="secondary_goals">Secondary Goals:</label>
        <input type="text" name="secondary_goals" placeholder="e.g., Improve flexibility, reduce body fat">

        <label for="experience_level">Experience Level:</label>
        <select name="experience_level" required>
          <option value="beginner">Beginner</option>
          <option value="intermediate">Intermediate</option>
          <option value="advanced">Advanced</option>
          <option value="expert">Expert</option>
        </select>

        <label for="medical_conditions">Medical Conditions:</label>
        <textarea name="medical_conditions" placeholder="e.g., Knee injuries, asthma"></textarea>

        <label for="fitness_assessment">Fitness Assessment:</label>
        <textarea name="fitness_assessment" placeholder="e.g., Weight: 75 kg, Height: 180 cm, Body fat: 20%"></textarea>

        <label for="mobility_issues">Mobility and Flexibility:</label>
        <textarea name="mobility_issues" placeholder="Any limitations in mobility"></textarea>

        <label for="time_commitment">Time Commitment (days/week):</label>
        <input type="number" name="time_commitment" min="1" max="7" required>

        <label for="activity_level">Activity Level:</label>
        <select name="activity_level" required>
          <option value="sedentary">Sedentary</option>
          <option value="moderately_active">Moderately Active</option>
          <option value="very_active">Very Active</option>
        </select>

        <label for="cardio_preference">Cardio Intensity Preference:</label>
        <select name="cardio_preference">
          <option value="low">Low</option>
          <option value="medium">Medium</option>
          <option value="high">High</option>
        </select>

        <label for="strength_preference">Strength Training Preference:</label>
        <select name="strength_preference">
          <option value="low">Low</option>
          <option value="medium">Medium</option>
          <option value="high">High</option>
        </select>

        <label for="workout_environment">Preferred Workout Environment:</label>
        <select name="workout_environment">
          <option value="gym">Gym</option>
          <option value="home">Home</option>
          <option value="outdoor">Outdoor</option>
        </select>

        <label for="diet_preference">Diet Preference:</label>
        <select name="diet_preference">
          <option value="vegan">Vegan</option>
          <option value="vegetarian">Vegetarian</option>
          <option value="keto">Keto</option>
          <option value="paleo">Paleo</option>
          <option value="balanced">Balanced</option>
        </select>

        <label for="daily_water_intake">Daily Water Intake (Liters):</label>
        <input type="number" name="daily_water_intake" min="0" max="10">

        <label for="mobility_flexibility">Mobility & Flexibility:</label>
        <textarea name="mobility_flexibility" id="mobility_flexibility" required></textarea>

        <button type="submit">Submit</button>
      </form>

      <?php include 'generate_workout_plan.php'; ?>

    </main>
  </div>
</body>

</html>