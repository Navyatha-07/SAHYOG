<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ✅ Check login
if (!isset($_SESSION['NGO_ID'])) {
    header("Location: login.php");
    exit;
}

$NGO_ID = $_SESSION['NGO_ID'];

// ✅ Connect to DB
$conn = new mysqli("localhost", "root", "", "sahyog1");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ✅ Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['Scheme_Title'];
    $description = $_POST['Scheme_Description'];
    $location = $_POST['location'];
    $category = $_POST['Category'];
    $scheme_date = $_POST['Scheme_Date'];
    $Eligibility = $_POST['Eligibility'];

    $stmt = $conn->prepare("INSERT INTO scheme (NGO_ID, Scheme_Title, Scheme_Description, location, Category, Scheme_Date, Posted_Date)
                            VALUES (?, ?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("isssss", $NGO_ID, $title, $description, $location, $category, $scheme_date);

    if ($stmt->execute()) {
        header("Location: Posted_Schemes.php?success=1");
        exit;
    } else {
        echo "❌ Error inserting scheme: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>

