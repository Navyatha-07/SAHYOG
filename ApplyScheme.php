<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

if (!isset($_SESSION['Rural_ID'])) {
    header("Location: 15_Rural-dashboard.html");
    exit;
}

if (!isset($_POST['apply'], $_POST['Scheme_ID'])) {
    echo "<p style='color:red;'>Invalid request</p>";
    exit;
}

$rural_id  = $_SESSION['Rural_ID'];
$scheme_id = intval($_POST['Scheme_ID']);

$conn = new mysqli("localhost", "root", "", "sahyog1");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$check = $conn->prepare(
    "SELECT 1 FROM schemeapplications 
     WHERE Rural_ID = ? AND Scheme_ID = ?"
);
$check->bind_param("ii", $rural_id, $scheme_id);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    // Already applied
    header("Location: AvailableSchemes.php");
    exit;
}
$check->close();


$stmt = $conn->prepare(
    "INSERT INTO schemeapplications (Rural_ID, Scheme_ID)
     VALUES (?, ?)"
);
$stmt->bind_param("ii", $rural_id, $scheme_id);
$stmt->execute();
$stmt->close();


$stmt2 = $conn->prepare(
    "SELECT NGO_ID FROM Scheme WHERE Scheme_ID = ?"
);
$stmt2->bind_param("i", $scheme_id);
$stmt2->execute();
$res = $stmt2->get_result();
$ngo_id = $res->fetch_assoc()['NGO_ID'] ?? null;
$stmt2->close();


if ($ngo_id) {
    $stmt3 = $conn->prepare(
        "INSERT INTO InterestedRurals (NGO_ID, Rural_ID, Scheme_ID)
         VALUES (?, ?, ?)"
    );
    $stmt3->bind_param("iii", $ngo_id, $rural_id, $scheme_id);
    $stmt3->execute();
    $stmt3->close();
}

$conn->close();

header("Location: Available_Schemes.php?applied=1");
exit;
?>
