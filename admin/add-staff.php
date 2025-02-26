<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['user_id'];
include 'DBconfig.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
    $name = $_POST['name'];
    $role = $_POST['role'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password']; 
   
    $query = "INSERT INTO Staff (name, role, email, phone, password) VALUES (?, ?, ?, ?, ?)";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("sssss", $name, $role, $email, $phone, $password);

        if ($stmt->execute()) {
            $message = "<p>Staff member added successfully!</p>";
        } else {
            $message = "<p>Error: " . $stmt->error . "</p>";
        }      
        $stmt->close();
    } else {
        $message = "<p>Failed to prepare the query.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Dashboard</title>
    <link rel="stylesheet" href="dashboard-styles.css">
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
        <?php include 'nav.php';?>
        </aside>

        <main class="content">
            <h3>Add Staff Member</h3>
            <form method="POST" action="add-staff.php">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required><br>

                <label for="role">Role:</label>
                <input type="text" id="role" name="role" required><br>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required><br>

                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" required><br>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required><br>

                <button type="submit">Add Staff</button>
            </form>

            <!-- Display success or error message after form submission -->
            <?php
            if (isset($message)) {
                echo $message;
            }
            ?>
        </main>
    </div>
</body>
</html>
