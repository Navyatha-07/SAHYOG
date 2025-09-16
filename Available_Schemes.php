<?php
$servername = "localhost";
$username = "root"; // change if needed
$password = "Navya@123"; // change if you set a MySQL password
$dbname = "sahyog1";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check 
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Schemes</title>
</head>
<body>
    <h2>Available Schemes</h2>
    <?php 
    $sql ="SELECT s.*, n.ngo_name
    FROM Scheme s
    JOIN ngo_users n ON .NGO_ID = n.NGO_ID
    WHERE s.status ='active'
    ORDER BY s.posted_date DESC";
    $result =$conn-> query($sql);
    while($row=$result-> fetch_assoc()){
        echo "<b>{$row['Scheme_Title']} </b>
        by NGO: {$row['ngo_name']}<br>";
        echo "{$row['Scheme_Description']}<br>";
         echo" Location: {$row['location']}|Eligibility:
        ({$row['Eligibility']})<br><hr>";
        echo" Scheme_Date: {$row['Scheme_Date']}|Category:
        ({$row['Category']})<br><hr>";
    }
    ?>
</body>
</html>