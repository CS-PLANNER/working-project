<?php
// Database connection details
$host = 'localhost'; // Your database host (e.g., 127.0.0.1)
$user = 'root'; // Your MySQL username
$password = ''; // Your MySQL password
$dbname = 'miniproject'; // Your database name

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("<script>alert('Connection failed: " . $conn->connect_error . "');</script>");
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from form
    $department = $_POST['department'];
    $year = $_POST['year'];
    $regNo = $_POST['regNo'];
    $studentName = $_POST['studentName'];

    // Get dept_id based on selected department (manually map it here)
    switch ($department) {
        case 'Bvoc Web Technology':
            $dept_id = 1;
            break;
        case 'BSC Computer Science':
            $dept_id = 2;
            break;
        case 'MSC Computer Science':
            $dept_id = 3;
            break;
        default:
            $dept_id = null;
    }

    // Validate if dept_id is valid
    if ($dept_id !== null) {
        // Prepare and bind SQL statement
        $stmt = $conn->prepare("INSERT INTO students (reg_no, name, dept_id, year, status) VALUES (?, ?, ?, ?, 1)");
        $stmt->bind_param("ssii", $regNo, $studentName, $dept_id, $year);

        // Execute the query
        if ($stmt->execute()) {
            echo "<script>alert('Student added successfully!'); window.location.href='student.html';</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "'); window.history.back();</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Invalid department selected!'); window.history.back();</script>";
    }
}

// Close the database connection
$conn->close();
?>
