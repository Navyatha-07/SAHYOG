<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

if (!isset($_POST['id']) || empty($_POST['id'])) {
    die("<p style='color:red;'>Invalid access. Please go back and click Apply again.</p>");
}

$_SESSION['Training_ID'] = $_POST['id'];
$Training_ID = $_POST['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Apply for Training</title>
<style>
body { font-family: Arial; text-align:center; margin-top:60px; }
button { background-color:#4B0082; color:white; padding:10px 20px; border:none; border-radius:6px; cursor:pointer; }
button:hover { background-color:#6a0dad; }
</style>
</head>
<body>
    <h2>Apply for Training</h2>
    <p>Training ID: <?= htmlspecialchars($Training_ID) ?></p>
    <form action="payment_amount.php" method="POST">
        <button type="submit">Proceed to Payment</button>
    </form>
</body>
</html>
