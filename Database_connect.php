<?php
$connection = mysqli_connect("localhost","root","","sahyog1");
if(!$connection){
    die("connection failed: ".mysqli_connect_error());
}
echo"connected succesfully";
?>