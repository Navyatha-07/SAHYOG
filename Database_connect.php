<?php
$connection = mysql_connect("localhost","root"," ",database);
if(!$connection){
    die("connection failed: ",.mysql_connect_error());
}
?>