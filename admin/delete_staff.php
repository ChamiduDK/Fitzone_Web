<?php
include 'DBconfig.php';

if (isset($_GET['id'])) {
    $staff_id = $_GET['id'];
    $delete_sql = "DELETE FROM Staff WHERE staff_id = '$staff_id'";

    if ($conn->query($delete_sql)) {
        header("Location: dashboard.php");
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
?>
