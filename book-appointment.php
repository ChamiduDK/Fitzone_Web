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
