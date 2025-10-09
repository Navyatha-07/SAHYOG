<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sahyog1";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$NGO_ID = $_SESSION['NGO_ID'];
$type = $_GET['type']; // job, scheme, training
$id = $_GET['id'];

$table = "";
$id_column = "";

if ($type == 'jobs') {
    $table = "jobs";
    $id_column = "Job_ID";
} elseif ($type == 'scheme') {
    $table = "scheme";
    $id_column = "Scheme_ID";
} elseif ($type == 'trainings') {
    $table = "trainings";
    $id_column = "Training_ID";
} else {
    die("Invalid type");
}

// 1️⃣ Delete related applications first
$stmt1 = $conn->prepare("DELETE FROM Applications WHERE App_ID = ? AND Type = ? AND NGO_ID = ?");
$stmt1->bind_param("isi", $id, $type, $NGO_ID);
$stmt1->execute();

// 2️⃣ Delete from main table
$stmt2 = $conn->prepare("DELETE FROM $table WHERE $id_column = ? AND NGO_ID = ?");
$stmt2->bind_param("ii", $id, $NGO_ID);

if ($stmt2->execute()) {
    echo "<script>alert('Deleted successfully'); 
    window.location.href='14_NGO_dashboard.html';</script>";
} else {
    echo "<script>alert('Error deleting');</script>";
}
?>
