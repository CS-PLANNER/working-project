<?php
session_start();
$conn = new mysqli("localhost", "root", "", "miniProject");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    if ($role === "admin") {
        $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $username, $password);
    } elseif ($role === "coordinator") {
        $stmt = $conn->prepare("SELECT * FROM coordinator WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $username, $password);
    } elseif ($role === "student") {
        $stmt = $conn->prepare("SELECT * FROM students WHERE reg_no = ?");
        $stmt->bind_param("s", $username);
    } else {
        echo "<script>alert('Access denied! Only admins, coordinators, and students can log in.');window.location.href='login.html';</script>";
        exit();
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $_SESSION['username'] = $username;
        
        if ($role === "admin") {
            header("Location: admin.html");
        } elseif ($role === "coordinator") {
            header("Location: announcements.html");
        } elseif ($role === "student") {
            header("Location: studentdetails.html");
        }
        exit();
    } else {
        echo "<script>alert('Invalid username');window.location.href='login.html';</script>";
    }
}
$conn->close();
?>