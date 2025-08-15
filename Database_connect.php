<?php
$connection = mysqli_connect("localhost","root","","SAHYOG");
if(!$connection){
    die("connection failed: ".mysqli_connect_error());
}
echo"connected succesfully";
?>