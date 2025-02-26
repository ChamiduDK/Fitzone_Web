<?php
include 'DBconfig.php';

if (isset($_GET['id'])) {
    $coach_id = $_GET['id'];
    $sql = "SELECT * FROM Coaches WHERE coach_id = '$coach_id'";
    $result = $conn->query($sql);
    $coach = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $specialization = $_POST['specialization'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $update_sql = "UPDATE Coaches SET name='$name', specialization='$specialization', email='$email', phone='$phone' WHERE coach_id='$coach_id'";
    if ($conn->query($update_sql)) {
        header("Location: dashboard.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<form method="post">
    <input type="text" name="name" value="<?php echo $coach['name']; ?>" required>
    <input type="text" name="specialization" value="<?php echo $coach['specialization']; ?>" required>
    <input type="email" name="email" value="<?php echo $coach['email']; ?>" required>
    <input type="text" name="phone" value="<?php echo $coach['phone']; ?>" required>
    <button type="submit">Update</button>
</form>
