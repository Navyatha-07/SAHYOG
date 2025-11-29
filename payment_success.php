<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (
    !isset($_SESSION['Rural_ID']) ||
    !isset($_SESSION['Training_ID']) ||
    !isset($_SESSION['amount']) ||
    !isset($_SESSION['method'])
) {
    echo "<p style='color:red; text-align:center; font-family:Arial;'>⚠️ Session expired or invalid payment process.</p>";
    echo "<p style='text-align:center;'><a href='15_Rural_dashboard.html'>Return to Dashboard</a></p>";
    exit;
}

// --- Assign session variables ---
$Rural_ID = $_SESSION['Rural_ID'];
$Training_ID = $_SESSION['Training_ID'];
$amount = $_SESSION['amount'];
$method = $_SESSION['method'];

// --- Database connection ---
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sahyog1";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);
$conn->begin_transaction();
try {
    // 1️⃣ Insert application if not exists
    $checkApp = $conn->prepare("SELECT * FROM training_applications 
    WHERE Rural_ID=? AND Training_ID=?");
    $checkApp->bind_param("ii", $Rural_ID, $Training_ID);
    $checkApp->execute();
    $appResult = $checkApp->get_result();
    if ($appResult->num_rows == 0) {
        $stmtApp = $conn->prepare("INSERT INTO training_applications
         (Rural_ID, Training_ID, Status) VALUES (?, ?, 'Applied')");
        $stmtApp->bind_param("ii", $Rural_ID, $Training_ID);
        $stmtApp->execute();
    }

    // 2️⃣ Insert payment record
    $stmtPayment = $conn->prepare("INSERT INTO payment
     (Rural_ID, Training_ID, Method, Amount, Status) 
     VALUES (?, ?, ?, ?, 'Success')");
    $stmtPayment->bind_param("iisd", $Rural_ID, $Training_ID, $method, $amount);
    $stmtPayment->execute();
$type = 'training';
    $app_id = $Training_ID;
    $applied_on = date('Y-m-d H:i:s');

    $stmtNGO = $conn->prepare("INSERT INTO Applications (Rural_ID, App_ID, Type, Applied_On) VALUES (?, ?, ?, ?)");
    $stmtNGO->bind_param("iiss", $Rural_ID, $app_id, $type, $applied_on);
    $stmtNGO->execute();

    // Commit transaction
    $conn->commit();

    // Clear sensitive session data
    unset($_SESSION['Training_ID'], $_SESSION['amount'], $_SESSION['method']);

} catch (Exception $e) {
    $conn->rollback();
    die("<p style='color:red;'>Payment failed: " . $e->getMessage() . "</p>");
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Payment Success</title>
<style>
    body { font-family: Arial, sans-serif; text-align:center; padding-top:50px; background:#f8f4ff; }
    .box { background:#fff; padding:40px; border-radius:15px; 
    box-shadow:0 0 20px rgba(0,0,0,0.2); width:400px; margin:auto; }
    h2 { color:green; }
    p { font-size:16px; color:#333; }
    button { background:#4B0082; color:white; padding:12px 25px; border:none;
     border-radius:10px; cursor:pointer; margin-top:20px; }
    button:hover { background:#6a0dad; }
</style>
</head>
<body>
<div class="box">
    <h2>✅ Payment Successful!</h2>
    <p><b>Training ID:</b> <?= htmlspecialchars($Training_ID) ?></p>
    <p><b>Payment Method:</b> <?= htmlspecialchars(ucfirst($method)) ?></p>
    <p><b>Amount Paid:</b> ₹<?= htmlspecialchars($amount) ?></p>
    <a href="MyInterests.php"><button>View My Interests</button></a>
</div>
</body>
</html>
