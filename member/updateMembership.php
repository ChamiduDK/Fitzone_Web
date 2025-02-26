<?php
include 'DBconfig.php';
session_start();

$user_id = $_SESSION["user_id"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["update"])) {
        $membership = $_POST["membership"];

        $stmt = $conn->prepare("UPDATE user SET membership = ? WHERE id = ?");
        $stmt->bind_param("si", $membership, $user_id);

        if ($stmt->execute()) {
            header("Location: dashboard.php?message=Membership updated");
        } else {
            echo "Error updating membership.";
        }
    } elseif (isset($_POST["cancel"])) {
        $stmt = $conn->prepare("UPDATE user SET membership = NULL WHERE id = ?");
        $stmt->bind_param("i", $user_id);

        if ($stmt->execute()) {
            header("Location: dashboard.php?message=Membership canceled");
        } else {
            echo "Error canceling membership.";
        }
    }

    $stmt->close();
    $conn->close();
}
?>
