<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
echo "<pre>POST: "; print_r($_POST); 
echo "SESSION: "; print_r($_SESSION); 
echo "</pre>";
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sahyog1";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);
if (!isset($_SESSION['Rural_ID'])) {
    header("Location: 15_Rural-dashboard.html");
    exit;
}
$rural_id = $_SESSION['Rural_ID'];
if (isset($_POST['apply']) && isset($_POST['Job_ID'])) {
    $type = 'jobs'; // keep same as your original code
    $id = intval($_POST['Job_ID']);
    $sql = "INSERT INTO Applications (Rural_ID, Job_ID) 
    VALUES (?, ?)";
    $ngoQuery = "SELECT NGO_ID FROM jobs WHERE Job_ID = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) die("Prepare failed: " . $conn->error);
    $stmt->bind_param("ii", $rural_id, $id);
    if (!$stmt->execute()) die("Execute failed: " . $stmt->error);
    $stmt->close();
    $stmt2 = $conn->prepare($ngoQuery);
    if (!$stmt2) die("Prepare failed: " . $conn->error);
    $stmt2->bind_param("i", $id);
    $stmt2->execute();
    $res = $stmt2->get_result();
    $row = $res->fetch_assoc();
    $ngo_id = $row['NGO_ID'] ?? null;
    $stmt2->close();
    if ($ngo_id) {
        $stmt3 = $conn->prepare("INSERT INTO InterestedRurals 
        (NGO_ID, Rural_ID, Job_ID) VALUES (?, ?, ?)");
        $stmt3->bind_param("iii", $ngo_id, $rural_id, $id);
        $stmt3->execute();
        $stmt3->close();
    }
    header("Location: MyInterests.php?applied=1");
    exit;
}

// --- Schemes and Trainings remain exactly as before ---
if (isset($_POST['apply'], $_POST['type'], $_POST['id'])) {
    $type = $_POST['type'];
    $id = intval($_POST['id']);

    if ($type == 'scheme') {
        $sql = "INSERT INTO Applications (Rural_ID, Scheme_ID) VALUES (?, ?)";
        $ngoQuery = "SELECT NGO_ID FROM Scheme WHERE Scheme_ID = ?";
    } elseif ($type == 'training') {
        $_SESSION['Pending_Training_ID'] = $id;
        header("Location: TrainingPayment.php");
        exit;
    } else {
        echo "<p style='color:red;'>Invalid application type!</p>";
        exit;
    }

    if (isset($sql)) {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $rural_id, $id);
        $stmt->execute();
        $stmt->close();

        $stmt2 = $conn->prepare($ngoQuery);
        $stmt2->bind_param("i", $id);
        $stmt2->execute();
        $res = $stmt2->get_result();
        $row = $res->fetch_assoc();
        $ngo_id = $row['NGO_ID'] ?? null;
        $stmt2->close();

        if ($ngo_id) {
            $job_id = null;
            $scheme_id = $type == 'scheme' ? $id : null;
            $stmt3 = $conn->prepare("INSERT INTO InterestedRurals (NGO_ID, Rural_ID, Job_ID, Training_ID, Scheme_ID) VALUES (?, ?, ?, NULL, ?)");
            $stmt3->bind_param("iiii", $ngo_id, $rural_id, $job_id, $scheme_id);
            $stmt3->execute();
            $stmt3->close();
        }

        header("Location: MyInterests.php?applied=1");
        exit;
    }
}

$conn->close();
?>
