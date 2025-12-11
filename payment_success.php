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

$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "sahyog1";

$conn = new mysqli($servername, $username, $password, $dbname);
// Check 
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$Rural_ID    = $_SESSION['Rural_ID'];
$Training_ID = $_SESSION['Training_ID'];
$Method      = $_SESSION['method'];
$Amount      = $_SESSION['amount'];

// Insert into training_applications
$stmt1 = $conn->prepare("
    INSERT INTO training_applications (Rural_ID, Training_ID, Date)
    VALUES (?, ?, NOW())
");
$stmt1->bind_param("ii", $Rural_ID, $Training_ID);
$stmt1->execute();
$stmt1->close();

// Insert into payment
$stmt2 = $conn->prepare("
    INSERT INTO payment (Rural_ID, Training_ID, Method, Amount,Status, Paid_On)
    VALUES (?, ?, ?, ?,'active', NOW())
");
$stmt2->bind_param("iisi", $Rural_ID, $Training_ID, $Method, $Amount);
$stmt2->execute();
$stmt2->close();

// Insert into applications (for NGO dashboard)
$stmt3 = $conn->prepare("
    INSERT INTO applications (Rural_ID, App_ID, Type, Applied_On)
    VALUES (?, ?, 'training', NOW())
");
$stmt3->bind_param("ii", $Rural_ID, $Training_ID);
$stmt3->execute();
$stmt3->close();

$conn->close();
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
