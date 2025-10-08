<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors',1);

if(!isset($_SESSION['NGO_ID'])){
    echo "<p style='color:red;'>You are not logged in!</p>";
    exit;
}

$NGO_ID = $_SESSION['NGO_ID'];

$conn = new mysqli("localhost","root","","sahyog1");
if($conn->connect_error) die("Connection failed: ".$conn->connect_error);

$stmt = $conn->prepare("SELECT * FROM Trainings WHERE NGO_ID = ? ORDER BY Posted_Date DESC");
$stmt->bind_param("i", $NGO_ID);
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
<h2>Your Posted Trainings</h2>
<?php
if(isset($_GET['success']) && $_GET['success'] == 1){
    echo '<p style="color: green;">Training Posted Successfully!</p>';
}

if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $title = $row['Training_Title'] ?? '';
        $desc = $row['Training_Description'] ?? '';
        $date = $row['Training_Date'] ?? '';
        $duration = $row['Duration'] ?? '';
        $location = $row['Location'] ?? '';
        $mode = $row['Mode'] ?? '';
        $eligibility = $row['Eligibility'] ?? '';
        $skills = $row['Skills'] ?? '';
        $contact = $row['Contact'] ?? '';

        echo "<b>$title</b> ($date)<br>";
        echo "$desc<br>";
        echo "Duration: $duration | Location: $location | Mode: $mode<br>";
        echo "Eligibility: $eligibility | Skills: $skills | Contact: $contact<br><hr>";
    }
} else {
    echo "<p>No trainings posted yet.</p>";
}
$stmt->close();
$conn->close();
?>
</body>
</html>

