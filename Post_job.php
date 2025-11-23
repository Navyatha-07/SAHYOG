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
    $Job_Title = $_POST['Job_Title'];
    $Job_Description = $_POST['Job_Description'];
    $location = $_POST['location'];
    $Job_Date = $_POST['Job_Date'];
    $Eligibility = $_POST['Eligibility'];
    $Salary = $_POST['Salary'];
    $Job_Type = $_POST['Job_Type'];
    $Eligibility = $_POST['Vacancies'];
    $Contact = $_POST['Contact'];

    $sql = "INSERT INTO jobs (NGO_ID, Job_Title, Job_Description,
     location, Job_Date, Eligibility,Salary,Job_Type, Vacancies, Contact, Posted_Date)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?,?,?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssssssss", $NGO_ID, $Job_Title, $Job_Description,
     $location, $Job_Date,$Eligibility, $Salary, $Job_Type,$Vacancies, $Contact);
    if($stmt->execute()){
        $stmt->close();
        $conn->close();
        header("Location: Posted_Jobs.php?success=1");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
