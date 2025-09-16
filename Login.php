<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors',1);
$servername ="localhost";
$username ="root";
$password ="Navya@123";
$dbname = "sahyog1";
$conn = new mysqli($servername,$username,$password,$dbname);
if($conn -> connect_error){
    die("connecion failed:".$conn-> connect_error);
}
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username =$_POST['username'];
    $password = $_POST['password'];
    $stmt =$conn -> prepare("SELECT fullname,password FROM ngo_users WHERE fullname=?");
    $stmt->bind_param("s",$username);
    $stmt -> execute();
    $stmt -> store_result();
    if($stmt -> num_rows == 1){
        $stmt -> bind_result($fullname,$hashedPassword);
        $stmt -> fetch();
        if(password_verify($password,$hashedPassword)){
            $_SESSION['NGO_ID'] = $NGO_ID;
            $_SESSION['username'] =$username;
            $_SESSION['usertype'] ='ngo';
            $stmt -> close();
            $conn-> close();
            header("location: 14_NGO_dashboard.html");
            exit;
        }
        else{
            $error ="Invalid USername or Password";
        }
    }
    else{
        $error="NGO not Found";
    }
    $stmt -> close();
    $stmt =$conn -> prepare("SELECT FullName,Password FROM rural_users WHERE FullName=?");
    $stmt->bind_param("s",$username);
    $stmt -> execute();
    $stmt -> store_result();
    if($stmt -> num_rows == 1){
        $stmt -> bind_result($FullName,$hashedPassword);
        $stmt -> fetch();
        if(password_verify($password,$hashedPassword)){
             $_SESSION['username'] =$username;
            $_SESSION['usertype'] ='rural';
            $stmt -> close();
            $conn-> close();
            header("location: 15_Rural_dashboard.html");
            exit;
        }
        else{
            $error ="Invalid USername or Password";
        }
        $stmt -> close();
    }
    $conn -> close();
    }
    ?>
