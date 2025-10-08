<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ✅ Connect to database
$conn = new mysqli("localhost", "root", "", "sahyog1");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ✅ Fetch all schemes (from all NGOs)
$query = "SELECT j.*, n.fullname
          FROM jobs j  
          JOIN ngo_users n ON j.NGO_ID = n.id
          ORDER BY j.Posted_Date DESC";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Available Jobs for Rural Users</title>
<style>
.scheme {
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 15px;
    margin: 10px 0;
    background-color: #f9f9f9;
}
.scheme h3 {
    margin: 0;
    color: #333;
}
.details {
    color: #555;
}
</style>
</head>
<body>
<h2>Available Jobs</h2>

<?php
if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            echo "<b>{$row['Job_Title']}</b> ({$row['Posted_Date']})<br>";
            echo "{$row['Job_Description']}<br>";
            echo "Location: {$row['location']} | Type: {$row['Job_Type']} | Salary: {$row['Salary']}<br>";
            echo "Eligibility: {$row['Eligibility']} | Contact: {$row['Contact']}<br>";
            echo "Posted by: {$row['fullname']}<hr>";
        }
    } 
else {
    echo "<p>No schemes available right now.</p>";
}
$conn->close();
?>
</body>
</html>
