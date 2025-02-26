<?php
session_start();
include 'DBconfig.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["signup"])) {
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT); 
        $phone = $_POST["phone"];
        $address = $_POST["address"];
        $membership = $_POST["membership"];

        // Insert data into the user table
        $stmt = $conn->prepare("INSERT INTO user (username, email, password, phone, address, membership) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $username, $email, $password, $phone, $address, $membership);

        if ($stmt->execute()) {
            // Insert data into the customers table
            $stmt_customer = $conn->prepare("INSERT INTO customers (name, email, password, address) VALUES (?, ?, ?, ?)");
            $stmt_customer->bind_param("ssss", $username, $email, $password, $address);

            if ($stmt_customer->execute()) {
                header("Location: login.php");
                exit;
            } else {
                $_SESSION['error_message'] = "Signup failed in customers table. Please try again.";
                header("Location: signup.php");
                exit;
            }
            $stmt_customer->close();
        } else {
            $_SESSION['error_message'] = "Signup failed in user table. Please try again.";
            header("Location: signup.php");
            exit;
        }
        $stmt->close();
        
    } elseif (isset($_POST["login"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];

        $stmt = $conn->prepare("SELECT id, username, password FROM user WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $username, $stored_password);
            $stmt->fetch();

            if (password_verify($password, $stored_password)) { 
                $_SESSION["user_id"] = $id;
                $_SESSION["username"] = $username;
                header("Location: dashboard.php");
                exit;
            } else {
                $_SESSION['error_message'] = "Invalid password.";
                header("Location: login.php");
                exit;
            }
        } else {
            $_SESSION['error_message'] = "No account found with that email.";
            header("Location: login.php");
            exit;
        }
        $stmt->close();
    }
} else {
    header("Location: login.php");
    exit;
}

$conn->close();
?>
