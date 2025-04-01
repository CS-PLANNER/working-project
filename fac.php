<?php
// Database connection details (replace with your actual credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "miniproject";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $faculty_name = $_POST["faculty_name"];
    $faculty_id = $_POST["faculty_id"];
    $email = $_POST["email"];
    $phone_number = $_POST["phone_number"];
    $department = $_POST["department"];

    // File upload handling
    $uploadDir = "uploads/"; // Create this folder in the same directory as your PHP file
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Create the directory if it doesn't exist
    }

    $resume_path = handleFileUpload($_FILES["resume"], $uploadDir);
    $research_papers_path = handleFileUpload($_FILES["research_papers"], $uploadDir);
    $certificates_path = handleFileUpload($_FILES["certificates"], $uploadDir);

    // SQL query to insert data into the database
    $sql = "INSERT INTO faculty_profiles (faculty_name, faculty_id, email, phone_number, department, resume_path, research_papers_path, certificates_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $faculty_name, $faculty_id, $email, $phone_number, $department, $resume_path, $research_papers_path, $certificates_path);

    if ($stmt->execute()) {
        echo "Profile submitted successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
}

$conn->close();

// Helper function for file uploads
function handleFileUpload($file, $uploadDir) {
    if ($file["error"] == UPLOAD_ERR_OK) {
        $filename = basename($file["name"]);
        $targetFilePath = $uploadDir . $filename;
        if (move_uploaded_file($file["tmp_name"], $targetFilePath)) {
            return $targetFilePath;
        } else {
            return null; // File upload failed
        }
    } else {
        return null; // No file uploaded or upload error
    }
}
?>