<?php
// Start the session to access $_SESSION variables
session_start();

// Check if user is logged in by verifying $_SESSION['user_id']
if (!isset($_SESSION['user_id'])) {
    echo "User not logged in.";
    exit;
}

// Assume user ID is obtained through login session
$user_id = $_SESSION['user_id'];

include 'DBconfig.php';

// Get POST data
$primary_goal = $_POST['primary_goal'];
$secondary_goals = $_POST['secondary_goals'];
$experience_level = $_POST['experience_level'];
$medical_conditions = $_POST['medical_conditions'];
$fitness_assessment = $_POST['fitness_assessment'];
$mobility_issues = $_POST['mobility_issues'];
$time_commitment = $_POST['time_commitment'];
$activity_level = $_POST['activity_level'];
$cardio_preference = $_POST['cardio_preference'];
$strength_preference = $_POST['strength_preference'];
$workout_environment = $_POST['workout_environment'];
$diet_preference = $_POST['diet_preference'];
$daily_water_intake = $_POST['daily_water_intake'];
$mobility_flexibility = $_POST['mobility_flexibility'];

// Insert the data into the database
$sql = "INSERT INTO user_health (user_id, primary_goal, secondary_goals, experience_level, medical_conditions, fitness_assessment, mobility_issues, time_commitment, activity_level, cardio_preference, strength_preference, workout_environment, diet_preference, daily_water_intake, mobility_flexibility) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("issssssissssssi", $user_id, $primary_goal, $secondary_goals, $experience_level, $medical_conditions, $fitness_assessment, $mobility_issues, $time_commitment, $activity_level, $cardio_preference, $strength_preference, $workout_environment, $diet_preference, $daily_water_intake, $mobility_flexibility);
$stmt->execute();

// Redirect to generate workout plan page
header("Location: workout-plan.php");
exit;
?>
