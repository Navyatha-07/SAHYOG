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
<body>
<h2>Training Payment</h2>
<p>Amount: ₹<?= $_SESSION['amount'] ?></p>
<a href="select_method.php">Pay Now</a>
</body>
</html>
