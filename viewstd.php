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
    die("<script>alert('Connection failed: " . $conn->connect_error . "');</script>");
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $department = $_POST['department'];
    $year = $_POST['year'];

    // Map department to dept_id
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
        // Prepare SQL query to fetch student records
        $sql = "SELECT reg_no, name, year, status FROM students WHERE dept_id = ? AND year = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $dept_id, $year);

        // Execute query
        $stmt->execute();
        $result = $stmt->get_result();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student List</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ecfadc;
    background-image: linear-gradient(225deg, #ecfadc 0%, #cdebc5 19%, #bee3ba 39%, #9fd4a3 60%, #ddf2d1 80%, #aedcae 100%);
    margin: 0;
            padding: 20px;
            display: flex;
    flex-direction: column;
    min-height: 100vh;
        }
        table {
            width: 80%;
            margin: auto;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }
        th {
            background-color:rgb(125, 172, 152);
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        h2 {
            text-align: center;
            color: #462B66;
        }
        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #4CAF50;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
        #logo {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            padding-right: 10px;
        }
        .index {
            text-align: center;
            background-color:rgb(74, 139, 110);
            margin-bottom: 5px;
            margin-right: 5px;
            margin-left: 5px;
            margin-top: 10px;
            color: white;
            font-size: 35px;
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
            padding-top: 15px;
            padding-bottom: 15px;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }
        #logout {
            background-color:rgb(99, 148, 103);
            width: 80px;
            border: none;
            padding: 8px;
            border-radius: 4px;
            cursor: pointer;
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #f9f9f9;
        }
    </style>
</head>
<body>

<!-- Navbar / Header -->
<header class="index">
    <img id="logo" src="vimala logo.jfif" alt="logo">
    <img id="logo" src="logo.png.jpeg" alt="vimala">
    CS DEPARTMENT PLANNER
    <button id="logout" onclick="logout()">Logout</button>
</header>

<h2>Student List - <?php echo htmlspecialchars($department); ?> (Year <?php echo htmlspecialchars($year); ?>)</h2>

<?php
if (isset($result) && $result->num_rows > 0) {
    echo "
    <table>
        <tr>
            <th>Register Number</th>
            <th>Student Name</th>
            <th>Year</th>
            <th>Status</th>
        </tr>
    ";
    // Fetch and display student records
    while ($row = $result->fetch_assoc()) {
        $status = ($row['status'] == 1) ? 'Active' : 'Inactive';
        echo "
        <tr>
            <td>" . htmlspecialchars($row['reg_no']) . "</td>
            <td>" . htmlspecialchars($row['name']) . "</td>
            <td>" . htmlspecialchars($row['year']) . "</td>
            <td>$status</td>
        </tr>";
    }
    echo "</table>";
} else {
    echo "<p style='text-align: center; color: red;'>No students found for the selected department and year.</p>";
}
?>

<a href="student.html">Go Back</a>

<!-- Logout Script -->
<script>
    function logout() {
        if (confirm("Are you sure you want to logout?")) {
            window.location.href = "login.html";
        }
    }
</script>

</body>
</html>

<?php
// Close statement and connection
if (isset($stmt)) {
    $stmt->close();
}
$conn->close();
?>
