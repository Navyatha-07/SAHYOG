<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['type']) && isset($_POST['id'])) {
        // Store form data into session
        $_SESSION['Training_ID'] = $_POST['id'];
        $_SESSION['type'] = $_POST['type'];

        // Set payment amount
        $amount = 50; // dummy amount
        $_SESSION['amount'] = $amount;
    } else {
        // If form data missing, go back to training list
        header("Location: 13_Rural_dashboard.html");
        exit;
    }
} else {
    // If directly accessed without POST, redirect to list
    header("Location: 13_Rural_dashboard.html");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head><title>Payment</title></head>
<link rel="stylesheet" href="stylesheet.css"/>
<body style="
margin: 0;
font-family: Arial,sans-serif;
background: #f2f6fb;
display: flex;
justify-content:center;
align-items:center;
height: 100vh;"
>
<div style="
background: #ffffff;
padding: 40px;
width: 350px;
text-align: center;
border-radius: 12px;
box-shadow: 0 8px 20px rgba(0,0,0,0.12);
border: 1px solid #e5e9f2;"
>
<h2 style="
margin : 0 0 15px;
font-size: 28px;
font-weight: 700;
color: #222;"
>
Training Payment
</h2>
<p style="
margin: 0 0 25px;
font-size: 20px;
color: #555;"
>Amount: ₹<?= $_SESSION['amount'] ?>
</p>
<a href="select_method.php" style="
display: block;
padding: 15px 0px;
font-size: 18px;
font-weight: bold;
text-decoration: none;
text-align: center;
background: #3563f9;
color: white;
border-radius: 8px;
transition: 0.15s ease">
Pay Now
</a>
</body>
</html>
