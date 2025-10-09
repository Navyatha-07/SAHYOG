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

if (!isset($_SESSION['Rural_ID']) || !isset($_SESSION['Pending_Training_ID'])) {
    echo "<p style='color:red;'>Invalid session. Please try again.</p>";
    exit;
}

$rural_id = $_SESSION['Rural_ID'];
$training_id = $_SESSION['Pending_Training_ID'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Simulate payment success
    echo "<p style='color:green;'>Payment Successful! Applying for training...</p>";

    // Insert into Applications
    $sql = "INSERT INTO Applications (Rural_ID, Training_ID) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $rural_id, $training_id);
    $stmt->execute();

    // Get NGO_ID
    $ngoQuery = "SELECT NGO_ID FROM Trainings WHERE Training_ID = ?";
    $stmt2 = $conn->prepare($ngoQuery);
    $stmt2->bind_param("i", $training_id);
    $stmt2->execute();
    $result = $stmt2->get_result();
    $row = $result->fetch_assoc();
    $ngo_id = $row['NGO_ID'] ?? null;

    if ($ngo_id) {
        $insertInterested = "INSERT INTO InterestedRurals (NGO_ID, Rural_ID, Job_ID, Training_ID, Scheme_ID)
                             VALUES (?, ?, ?, ?, ?)";
        $stmt3 = $conn->prepare($insertInterested);
        $job_id = null;
        $scheme_id = null;
        $stmt3->bind_param("iiiii", $ngo_id, $rural_id, $job_id, $training_id, $scheme_id);
        $stmt3->execute();
        $stmt3->close();
    }

    unset($_SESSION['Pending_Training_ID']);
    header("Refresh: 2; URL=MyInterests.php?payment=success");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Training Payment</title>
<style>
body {
    font-family: Arial;
    text-align: center;
    margin-top: 100px;
}
button {
    background-color: #4CAF50;
    color: white;
    padding: 12px 24px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}
button:hover {
    background-color: #45a049;
}
</style>
</head>
<body>
    <h2>Training Payment</h2>
    <p>Amount: ₹299 (Dummy Payment)</p>
    <form method="POST">
        <button type="submit">Pay Now</button>
    </form>
</body>
</html>
