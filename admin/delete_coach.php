<?php
include 'DBconfig.php';

if (isset($_GET['id'])) {
    $coach_id = $_GET['id'];
    $delete_sql = "DELETE FROM Coaches WHERE coach_id = '$coach_id'";

    if ($conn->query($delete_sql)) {
        header("Location: dashboard.php");
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
?>
