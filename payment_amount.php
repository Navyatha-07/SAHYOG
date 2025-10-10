<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
if(!isset($_SESSION['Training_ID'])) header("Location: select_method.php");
$amount = 50; // dummy amount
$_SESSION['amount'] = $amount;
?>
<!DOCTYPE html>
<html>
<head><title>Payment</title></head>
<body>
<h2>Training Payment</h2>
<p>Amount: ₹<?= $amount ?></p>
<a href="select_method.php">Pay Now</a>
</body>
</html>
