<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['Rural_ID'])) {
    exit("Unauthorized");
}

if (!isset($_POST['apply'], $_POST['Job_ID'])) {
    exit("Invalid request");
}

$Rural_ID = $_SESSION['Rural_ID'];
$Job_ID   = intval($_POST['Job_ID']);

$conn = new mysqli("localhost", "root", "", "sahyog1");
if ($conn->connect_error) {
    die("Connection failed");
}

/* Prevent duplicate apply */
$check = $conn->prepare(
    "SELECT 1 FROM JobApplications WHERE Rural_ID = ? AND Job_ID = ?"
);
$check->bind_param("ii", $Rural_ID, $Job_ID);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    header("Location: Availablejobs.php");
    exit;
}
$check->close();

/* Insert application */
$stmt = $conn->prepare(
    "INSERT INTO JobApplications (Rural_ID, Job_ID) VALUES (?, ?)"
);
$stmt->bind_param("ii", $Rural_ID, $Job_ID);
$stmt->execute();
$stmt->close();

$conn->close();

header("Location: Availablejobs.php");
exit;
?>
