<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sahyog1";

$conn = new mysqli($servername, $username, $password, $dbname);
if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all jobs
$stmt = $conn->prepare("SELECT Jobs.*, ngo_users.nameofNGO FROM Jobs 
                        JOIN ngo_users ON Jobs.NGO_ID = ngo_users.id
                        ORDER BY Posted_Date DESC");
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Posted Jobs</title>
</head>
<body>
    <h2>All Posted Jobs</h2>
    <?php
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            echo "<b>{$row['Job_Title']}</b> ({$row['Posted_Date']})<br>";
            echo "{$row['Job_Description']}<br>";
            echo "Location: {$row['location']} | Type: {$row['Job_Type']} | Salary: {$row['Salary']}<br>";
            echo "Eligibility: {$row['Eligibility']} | Contact: {$row['Contact']}<br>";
            echo "Posted by: {$row['nameofNGO']}<hr>";
        }
    } else {
        echo "No jobs posted yet.";
    }
    $stmt->close();
    $conn->close();
    ?>
</body>
</html>

