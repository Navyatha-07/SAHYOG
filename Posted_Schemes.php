<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors',1);

// --- Login check ---
if(!isset($_SESSION['NGO_ID'])){
    header("Location: login.php");
    exit;
}

$NGO_ID = $_SESSION['NGO_ID'];

$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "sahyog1";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$stmt = $conn->prepare("SELECT * FROM Scheme WHERE NGO_ID = ? ORDER BY Posted_Date DESC");
$stmt->bind_param("i", $NGO_ID);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Posted Schemes</title>
</head>
<body>
<h2>Your Posted Schemes</h2>
<?php
if(isset($_GET['success']) && $_GET['success'] == 1){
    echo '<p style="color: green;">Scheme Posted Successfully!</p>';
}

if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        echo "<b>{$row['Scheme_Title']}</b> ({$row['Scheme_Date']})<br>";
        echo "{$row['Scheme_Description']}<br>";
        echo "Location: {$row['location']} | Category: {$row['Category']}<br><hr>";
    }
} else {
    echo "<p>No schemes posted yet.</p>";
}
$stmt->close();
$conn->close();
?>
</body>
</html>
