<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

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

// Fetch faculty details
$sql = "SELECT faculty_id, name, email, phone, status FROM faculty";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty List</title>
    <style>
        body {
            background-color: #FFDEE9;
            background-image: linear-gradient(0deg, #FFDEE9 0%, #B5FFFC 100%);
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .index {
            text-align: center;
            background-color: #FFDEE9;
            margin: 10px 5px;
            color: #462B66;
            font-size: x-large;
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
            padding: 15px;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }
        #logout {
            background-color: #f0a3ed;
            width: 80px;
            border: none;
            padding: 8px;
            border-radius: 4px;
            cursor: pointer;
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
        }
        #logo {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            padding-right: 10px;
        }
        h2 {
            text-align: center;
            color: #462B66;
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
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
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
    </style>
</head>
<body>

    <header class="index">
        <img id="logo" src="vimala logo.jfif" alt="logo" width="35px" height="35px">
        <img id="logo" src="logo.png.jpeg" alt="vimala" width="35px" height="35px">
        CS DEPARTMENT PLANNER
        <button id="logout">Logout</button>
    </header>

    <h2>Faculty List</h2>

    <?php
    if ($result->num_rows > 0) {
        echo "
        <table>
            <tr>
                <th>Faculty ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Contact Number</th>
                <th>Status</th>
            </tr>
        ";

        // Fetch and display records
        while ($row = $result->fetch_assoc()) {
            $status = ($row['status'] == 1) ? 'Active' : 'Inactive';
            echo "
            <tr>
                <td>" . htmlspecialchars($row['faculty_id']) . "</td>
                <td>" . htmlspecialchars($row['name']) . "</td>
                <td>" . htmlspecialchars($row['email']) . "</td>
                <td>" . htmlspecialchars($row['phone']) . "</td>
                <td>$status</td>
            </tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='text-align: center;'>No faculty found.</p>";
    }

    // Close the connection
    $conn->close();
    ?>

    <a href="faculty.html">Go Back</a>
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
