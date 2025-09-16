<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors",1);
$servername = "localhost";
$username = "root"; 
$password = "Navya@123"; 
$dbname = "sahyog1";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if(!isset($_SESSION['NGO_ID'])){
    echo "<p style='color:red;'>
    You are not logged in!</p>";
    exit;
}
$NGO_ID =$_SESSION['NGO_ID'];
$success =isset($_GET['success']) && $_GET['success'] == 1;
$stmt =$conn -> prepare("SELECT * from Scheme WHERE NGO_ID = ? order By Posted_Date=DESC");
$stmt -> bind_param("i",$NGO_ID);
$stmt ->execute();
$result = $stmt -> get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posted Schemes</title>
</head>
<body>
    <?php
    if(isset($_GET['success'])){
 echo '<p style="color: green;"> Scheme Posted Successfully!</p>';
    }
 ?>
    <h2>Your Posted Schemes</h2>
    <?php
    if($result -> num_rows > 0){
    while($row =$result-> fetch_assoc()){
        echo"<b>{$row['Scheme_Title']}</b>
        ({$row['Scheme_Date']})<br>";
        echo"{$row['Scheme_Description']}<br>";
        echo" Location: {$row['location']}|Category:
        ({$row['Category']})<br><hr>";
    }
}
    else{
        echo " No schemes posed yet.";
    }
    $stmt->close();
    $conn -> close();
    ?>
</body>
</html>