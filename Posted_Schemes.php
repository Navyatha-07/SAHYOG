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
        $title = isset($row['Scheme_Title']) ? $row['Scheme_Title'] : '';
        $desc = isset($row['Scheme_Description']) ? $row['Scheme_Description'] : '';
        $location = isset($row['location']) ? $row['location'] : '';
        $category = isset($row['Category']) ? $row['Category'] : '';
        $date = isset($row['Scheme_Date']) ? $row['Scheme_Date'] : '';

        echo "<b>$title</b> ($date)<br>";
        echo "$desc<br>";
        echo "Location: $location | Category: $category<br><hr>";
    }
} else {
    echo "<p>No schemes posted yet.</p>";
}
$stmt->close();
$conn->close();
?>
</body>
</html>

