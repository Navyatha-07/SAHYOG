<?php
echo"<pre>";
print_r($_SESSION);
echo "</pre>";
exit;
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
if(!isset($_SESSION['RuralUser_ID'])){
    echo" Please Login First";
    exit;
}
$RuralUser_ID =$_SESSION['RuralUser_ID'];

// Connect to database
$conn = new mysqli("localhost", "root", "", "sahyog1");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all schemes (from all NGOs)
$query = "SELECT s.*, n.fullname
          FROM scheme s 
          JOIN ngo_users n ON s.NGO_ID = n.id
          ORDER BY s.Posted_Date DESC";

$result = $conn->query($query);
if(!$result) die("Query error:".$conn -> error);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Available Schemes for Rural Users</title>
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
<h2>Available Schemes</h2>

<?php
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='scheme'>";
        echo "<h3>" . htmlspecialchars($row['Scheme_Title']) . "</h3>";
        echo "<p>" . nl2br(htmlspecialchars($row['Scheme_Description'])) . "</p>";
        echo "<div class='details'>";
        echo "📍 Location: " . htmlspecialchars($row['location']) . "<br>";
        echo "🏷 Category: " . htmlspecialchars($row['Category']) . "<br>";
        echo "📅 Scheme Date: " . htmlspecialchars($row['Scheme_Date']) . "<br>";
        echo "🏛 Posted by: " . htmlspecialchars($row['fullname']) . "<br>";
        echo "</div></div>";

        echo "<form method ='POST' action = 'ApplyScheme.php'>";
        echo "<input type ='hidden' name='Scheme_ID' value ='".$row['Scheme_ID']."'>";
        echo " <button type ='submit' > Apply</button>";
        echo "</form>";
    }
} else {
    echo "<p>No schemes available right now.</p>";
}
$conn->close();
?>
</body>
</html>
