<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if(!isset($_SESSION['RuralUser_ID'])){
    header("Location: Login.php");
    exit;
}
$RuralUser_ID =$_SESSION['RuralUSer_ID'];
$Scheme_ID =$_POST['Scheme_ID'];

$conn = new mysqli("localhost", "root", "", "sahyog1");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    $stmt =$conn -> prepare("INSERT INTO applied_schemes(Scheme_ID,RuralUser_ID) values (?,?)";
    $stmt -> bind_param('ii',$Scheme_ID,$RuralUser_ID);
    if($stmt -> executed()){
        echo "<script>
        alert('Successfully applied ! Within 24 hours ,NGO will contact you.');
        window.location ='myinterests.php';
        </script>";
    }
    else{
        echo "Error:".$stmt -> error;
    }
    $stmt -> close();
    $conn -> close();
}