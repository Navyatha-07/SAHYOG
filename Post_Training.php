<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors",1);
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "sahyog1";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if(!isset($_SESSION['NGO_ID'])){
    echo "<p style='color:red;'>You are not logged in!</p>";
    exit;
}
$NGO_ID = $_SESSION['NGO_ID'];
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $Training_Title = $_POST['Training_Title'];
    $Training_Description = $_POST['Training_Description'];
    $Training_Date = $_POST['Training_Date'];
    $Duration = $_POST['Duration'];
    $location = $_POST['location'];
    $Mode = $_POST['Mode'];
    $Eligibility = $_POST['Eligibility'];
    $Skills = $_POST['Skills'];
    $Contact = $_POST['Contact'];
    $sql = "INSERT INTO trainings (NGO_ID, Training_Title,
     Training_Description,Training_Date, Duration, location, 
     Mode, Eligibility, Skills, Contact, Posted_Date)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?,?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssssssss", $NGO_ID, $Training_Title,
     $Training_Description,$Training_Date, $Duration, $location, $Mode,
      $Eligibility, $Skills, $Contact);
    if($stmt->execute()){
        $stmt->close();
        $conn->close();
        header("Location: Posted_Trainings.php?success=1");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
