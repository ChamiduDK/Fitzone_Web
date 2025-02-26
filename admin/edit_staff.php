<?php
include 'DBconfig.php';

if (isset($_GET['id'])) {
    $staff_id = $_GET['id'];
    $sql = "SELECT * FROM Staff WHERE staff_id = '$staff_id'";
    $result = $conn->query($sql);
    $staff = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $role = $_POST['role'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $update_sql = "UPDATE Staff SET name='$name', role='$role', email='$email', phone='$phone' WHERE staff_id='$staff_id'";
    if ($conn->query($update_sql)) {
        header("Location: dashboard.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<form method="post">
    <input type="text" name="name" value="<?php echo $staff['name']; ?>" required>
    <input type="text" name="role" value="<?php echo $staff['role']; ?>" required>
    <input type="email" name="email" value="<?php echo $staff['email']; ?>" required>
    <input type="text" name="phone" value="<?php echo $staff['phone']; ?>" required>
    <button type="submit">Update</button>
</form>
