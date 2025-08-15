<?php
echo "hello world";
$host = "localhost";
$username ="root";
$password ="";
$databasename ="database";
$connection = mysqli_connect($host , $username , $password , $databasename);
if(!$connection){
    die("connection failed: ".mysqli_connect_error());
}
echo "Success";
?>