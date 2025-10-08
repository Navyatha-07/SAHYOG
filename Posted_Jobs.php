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

$stmt = $conn->prepare("SELECT * FROM Jobs WHERE NGO_ID = ? ORDER BY Posted_Date DESC");
$stmt->bind_param("i", $NGO_ID);
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
<h2>Your Posted Jobs</h2>
<?php
if(isset($_GET['success']) && $_GET['success'] == 1){
    echo '<p style="color: green;">Job Posted Successfully!</p>';
}

if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $title = $row['Job_Title'] ?? '';
        $desc = $row['Job_Description'] ?? '';
        $location = $row['location'] ?? '';
        $type = $row['Job_Type'] ?? '';
        $salary = $row['Salary'] ?? '';
        $eligibility = $row['Eligibility'] ?? '';
        $experience = $row['Experience'] ?? '';
        $contact = $row['Contact'] ?? '';

        echo "<b>$title</b> ($type)<br>";
        echo "$desc<br>";
        echo "Location: $location | Salary: $salary | Eligibility: $eligibility<br>";
        echo "Experience: $experience | Contact: $contact<br><hr>";
    }
} else {
    echo "<p>No jobs posted yet.</p>";
}
$stmt->close();
$conn->close();
?>
</body>
</html>

