<?php
include 'DBconfig.php';
session_start();

$user_id = $_SESSION["user_id"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];

    $stmt = $conn->prepare("UPDATE user SET username = ?, email = ?, phone = ?, address = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $username, $email, $phone, $address, $user_id);

    if ($stmt->execute()) {
        header("Location: dashboard.php?message=Profile updated");
    } else {
        echo "Error updating profile.";
    }

    $stmt->close();
    $conn->close();
}
?>
