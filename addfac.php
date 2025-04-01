<?php
// Database connection details
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'miniproject';

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("<script>alert('Connection failed: " . $conn->connect_error . "'); window.location.href='addfaculty.html';</script>");
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from the form
    $faculty_id = $_POST['facId'];
    $name = $_POST['facultyName'];
    $email = $_POST['emailId'];
    $phone = $_POST['phNo'];

    // Validate inputs
    if (!empty($faculty_id) && !empty($name) && !empty($email) && !empty($phone)) {
        // Prepare SQL to insert data into faculty table
        $sql = "INSERT INTO faculty (faculty_id, name, email, phone, status) VALUES (?, ?, ?, ?, 1)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $faculty_id, $name, $email, $phone);

        // Execute the statement
        if ($stmt->execute()) {
            echo "<script>alert('Faculty added successfully!'); window.location.href='faculty.html';</script>";
        } else {
            echo "<script>alert('Error adding faculty: " . $stmt->error . "'); window.location.href='addfaculty.html';</script>";
        }

        // Close statement
        $stmt->close();
    } else {
        echo "<script>alert('Please fill all fields.'); window.history.back();</script>";
    }
}

// Close the connection
$conn->close();
?>
