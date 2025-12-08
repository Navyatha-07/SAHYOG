<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors',1);

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header("Location: select_method.php");
    exit;
}

$method = $_SESSION['method'] ?? '';

$card  = $_POST['card'] ?? '';
$expiry = $_POST['expiry'] ?? '';
$cvv = $_POST['cvv'] ?? '';
$upi = $_POST['upi'] ?? '';
?>

<!DOCTYPE html>
<html>
<body style="
font-family:Arial;
background:#f8f4ff;
text-align:center;
padding-top:60px;">

<div style="
background:white; 
padding:40px;
border-radius:12px;
width:400px;
margin:auto;
box-shadow:0 0 20px rgba(0,0,0,0.2);">

<h2 style="color:green;">Payment Successful!</h2>

<p>NGO will reach out to you within 24 hours!</p>

<a href="MyInterests.php">
<button style="
background:#4B0082;
color:white;
padding:12px 25px;
border:none;
border-radius:10px;
margin-top:20px;">View My Interests</button>
</a>

</div>

</body>
</html>
