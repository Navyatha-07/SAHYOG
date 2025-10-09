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

if (!isset($_SESSION['Rural_ID'])) {
    echo "<p style='color:red;'>You are not logged in!</p>";
    exit;
}

$rural_id = $_SESSION['Rural_ID'];

if (isset($_POST['apply'], $_POST['type'], $_POST['id'])) {
    $type = $_POST['type'];
    $id = intval($_POST['id']);

    // If it's a training, go to payment first
    if ($type === 'training') {
        $_SESSION['Pending_Training_ID'] = $id;
        header("Location: payment.php");
        exit;
    }

    // ✅ Normal application for jobs or schemes
    if ($type === 'scheme') {
        $sql = "INSERT INTO Applications (Rural_ID, Scheme_ID) VALUES (?, ?)";
        $ngoQuery = "SELECT NGO_ID FROM scheme WHERE Scheme_ID = ?";
    } elseif ($type === 'job') {
        $sql = "INSERT INTO Applications (Rural_ID, Job_ID) VALUES (?, ?)";
        $ngoQuery = "SELECT NGO_ID FROM Jobs WHERE Job_ID = ?";
    } else {
        echo "<p style='color:red;'>Invalid application type!</p>";
        exit;
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $rural_id, $id);

    if ($stmt->execute()) {
        $stmt2 = $conn->prepare($ngoQuery);
        $stmt2->bind_param("i", $id);
        $stmt2->execute();
        $result = $stmt2->get_result();
        $row = $result->fetch_assoc();
        $ngo_id = $row['NGO_ID'] ?? null;

        if ($ngo_id) {
            $insertInterested = "INSERT INTO InterestedRurals (NGO_ID, Rural_ID, Job_ID, Training_ID, Scheme_ID)
                                 VALUES (?, ?, ?, ?, ?)";
            $stmt3 = $conn->prepare($insertInterested);
            $job_id = ($type === 'job') ? $id : null;
            $training_id = null;
            $scheme_id = ($type === 'scheme') ? $id : null;
            $stmt3->bind_param("iiiii", $ngo_id, $rural_id, $job_id, $training_id, $scheme_id);
            $stmt3->execute();
            $stmt3->close();
        }

        echo "<p style='color:green;'>Applied successfully! Redirecting...</p>";
        header("Refresh: 2; URL=MyInterests.php?applied=1");
        exit;
    } else {
        echo "<p style='color:red;'>Error while applying: " . htmlspecialchars($stmt->error) . "</p>";
    }

    $stmt->close();
}

$conn->close();
?>
