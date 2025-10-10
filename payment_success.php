<?php
session_start();

// --- Database connection ---
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sahyog1";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("<p style='color:red;'>Connection failed: " . $conn->connect_error . "</p>");
}

// --- Debug check (remove later) ---
// echo "<pre>"; print_r($_SESSION); echo "</pre>";

// --- Validate session data ---
if (
    !isset($_SESSION['Training_ID']) ||
    !isset($_SESSION['method']) ||
    !isset($_SESSION['Amount']) ||
    !isset($_SESSION['Rural_ID'])
) {
    echo "<p style='color:red; text-align:center; font-family:Arial;'>⚠️ Session expired or invalid payment process.</p>";
    echo "<p style='text-align:center;'><a href='15_Rural_dashboard.html'>Return to Dashboard</a></p>";
    exit;
}

// --- Assign session variables ---
$Training_ID = $_SESSION['Training_ID'];
$method = $_SESSION['method'];
$Amount = $_SESSION['Amount'];
$Rural_ID = $_SESSION['Rural_ID'];

// --- Store payment in database ---
$payment_sql = "INSERT INTO payment (Rural_ID, Training_ID, Method, Amount, Status)
                VALUES (?, ?, ?, ?, 'Success')";
$stmt = $conn->prepare($payment_sql);
$stmt->bind_param("iisd", $Rural_ID, $Training_ID, $method, $Amount);
$stmt->execute();

// --- Store training application ---
$app_sql = "INSERT INTO training_applications (Rural_ID, Training_ID, Status)
            VALUES (?, ?, 'Applied')";
$stmt2 = $conn->prepare($app_sql);
$stmt2->bind_param("ii", $Rural_ID, $Training_ID);
$stmt2->execute();

// --- Clear sensitive data after success ---
unset($_SESSION['Training_ID'], $_SESSION['method'], $_SESSION['Amount']);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Payment Success</title>
<style>
    body {
        font-family: "Segoe UI", Arial, sans-serif;
        background: linear-gradient(to right, #f8f4ff, #ece8ff);
        text-align: center;
        padding-top: 80px;
    }
    .success-box {
        background-color: #fff;
        width: 400px;
        margin: auto;
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 0 20px rgba(0,0,0,0.2);
    }
    h2 {
        color: green;
    }
    p {
        font-size: 16px;
        color: #333;
    }
    button {
        background-color: #4B0082;
        color: white;
        padding: 12px 25px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-size: 16px;
        margin-top: 20px;
    }
    button:hover {
        background-color: #6a0dad;
    }
</style>
</head>
<body>
<div class="success-box">
    <h2>✅ Payment Successful!</h2>
    <p><b>Training ID:</b> <?= htmlspecialchars($Training_ID) ?></p>
    <p><b>Payment Method:</b> <?= htmlspecialchars(ucfirst($method)) ?></p>
    <p><b>Amount Paid:</b> ₹<?= htmlspecialchars($Amount) ?></p>
    <a href="15_Rural_dashboard.html"><button>Back to Dashboard</button></a>
</div>
</body>
</html>
