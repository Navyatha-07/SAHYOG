<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['Rural_ID']) || !isset($_SESSION['Pending_Training_ID'])) {
    // If session expired, redirect to dashboard directly
    header("Location: 15_Rural_dashboard.html");
    exit;
}

$rural_id = $_SESSION['Rural_ID'];
$training_id = $_SESSION['Pending_Training_ID'];

// Check if form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pay'])) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sahyog1";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

    // 1️⃣ Insert into Applications table
    $sql = "INSERT INTO Applications (Rural_ID, Training_ID) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $rural_id, $training_id);
    $stmt->execute();
    $stmt->close();

    // 2️⃣ Get NGO_ID for this training
    $stmt2 = $conn->prepare("SELECT NGO_ID FROM Trainings WHERE Training_ID = ?");
    $stmt2->bind_param("i", $training_id);
    $stmt2->execute();
    $result = $stmt2->get_result();
    $row = $result->fetch_assoc();
    $ngo_id = $row['NGO_ID'] ?? null;
    $stmt2->close();

    // 3️⃣ Insert into InterestedRurals table
    if ($ngo_id) {
        $stmt3 = $conn->prepare("INSERT INTO InterestedRurals (NGO_ID, Rural_ID, Job_ID, Training_ID, Scheme_ID)
                                 VALUES (?, ?, ?, ?, ?)");
        $job_id = null;
        $scheme_id = null;
        $stmt3->bind_param("iiiii", $ngo_id, $rural_id, $job_id, $training_id, $scheme_id);
        $stmt3->execute();
        $stmt3->close();
    }

    $conn->close();

    // Clear session so back button won't break
    unset($_SESSION['Pending_Training_ID']);

    // Redirect to MyInterests with a success flag
    header("Location: MyInterests.php?payment=success");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Processing Payment...</title>
<style>
body { font-family: Arial; text-align: center; margin-top: 100px; }
</style>
</head>
<body>
<h2>Payment Successful!</h2>
<p>Applying for the training...</p>
<p>You will be redirected shortly.</p>
</body>
</html>
