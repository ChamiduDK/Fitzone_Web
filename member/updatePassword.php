<?php
include 'DBconfig.php';
session_start();

$user_id = $_SESSION["user_id"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = $_POST["current_password"];
    $new_password = $_POST["new_password"];

    // Fetch the hashed password from the database
    $stmt = $conn->prepare("SELECT password FROM user WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($stored_password);
    $stmt->fetch();
    $stmt->close();

    // Verify the current password
    if (password_verify($current_password, $stored_password)) {
        // Hash the new password before storing
        $hashed_new_password = password_hash($new_password, PASSWORD_BCRYPT);

        $stmt = $conn->prepare("UPDATE user SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $hashed_new_password, $user_id);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Password updated successfully.";
        } else {
            $_SESSION['message'] = "Error updating password.";
        }
        
        $stmt->close();
    } else {
        $_SESSION['message'] = "Current password is incorrect.";
    }

   
    header("Location: settings.php");
    exit();
}
?>
