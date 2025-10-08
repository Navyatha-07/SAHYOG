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

if(!isset($_SESSION['Rural_ID'])) {
    echo "<p style='color:red;'>You are not logged in!</p>";
    exit;
}

$rural_id = $_SESSION['Rural_ID'];

if (isset($_POST['apply'])) {
    $type = $_POST['type'];
    $id = $_POST['id'];

    if ($type == 'scheme') {
        $sql = "INSERT INTO Applications (Rural_ID, Scheme_ID) VALUES (?, ?)";
    } elseif ($type == 'training') {
        $sql = "INSERT INTO Applications (Rural_ID, Training_ID) VALUES (?, ?)";
    } elseif ($type == 'job') {
        $sql = "INSERT INTO Applications (Rural_ID, Job_ID) VALUES (?, ?)";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $rural_id, $id);

    if ($stmt->execute()) {
        header("Location: MyInterests.php?applied=1");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>
