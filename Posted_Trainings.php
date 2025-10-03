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

// Fetch all trainings
$stmt = $conn->prepare("SELECT Trainings.*, ngo_users.nameofNGO FROM Trainings 
                        JOIN ngo_users ON Trainings.NGO_ID = ngo_users.id
                        ORDER BY Posted_Date DESC");
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Posted Trainings</title>
</head>
<body>
    <h2>All Posted Trainings</h2>
    <?php
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            echo "<b>{$row['Training_Title']}</b> ({$row['Posted_Date']})<br>";
            echo "{$row['Training_Description']}<br>";
            echo "Duration: {$row['Duration']} | Location: {$row['location']} | Mode: {$row['Mode']}<br>";
            echo "Eligibility: {$row['Eligibility']} | Skills: {$row['Skills']} | Contact: {$row['Contact']}<br>";
            echo "Posted by: {$row['nameofNGO']}<hr>";
        }
    } else {
        echo "No trainings posted yet.";
    }
    $stmt->close();
    $conn->close();
    ?>
</body>
</html>


