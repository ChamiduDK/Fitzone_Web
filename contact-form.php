<?php
session_start(); 

include 'DBconfig.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $message = $conn->real_escape_string($_POST['message']);
    $sql = "INSERT INTO contacts (name, email, message) VALUES ('$name', '$email', '$message')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Thank you for your message! We will get back to you soon.";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "There was an error sending your message. Please try again later.";
        $_SESSION['message_type'] = "error";
    }

    header("Location: contact.php");
    exit();
}

$conn->close();
?>
