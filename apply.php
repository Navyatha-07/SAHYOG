<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sahyog1";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if (!isset($_SESSION['Rural_ID'])) {
    header("Location: 15_Rural-dashboard.html"); // redirect instead of error
    exit;
}

$rural_id = $_SESSION['Rural_ID'];

if (isset($_POST['apply'], $_POST['type'], $_POST['id'])) {
    $type = $_POST['type'];
    $id = intval($_POST['id']);

    if ($type == 'scheme') {
        $sql = "INSERT INTO Applications (Rural_ID, Scheme_ID) VALUES (?, ?)";
        $ngoQuery = "SELECT NGO_ID FROM Scheme WHERE Scheme_ID = ?";
    } elseif ($type == 'training') {
        // Set session for payment redirection
        $_SESSION['Pending_Training_ID'] = $id;
        header("Location: TrainingPayment.php");
        exit;
    } elseif ($type == 'job') {
        $sql = "INSERT INTO Applications (Rural_ID, Job_ID) VALUES (?, ?)";
        $ngoQuery = "SELECT NGO_ID FROM Jobs WHERE Job_ID = ?";
    } else {
        echo "<p style='color:red;'>Invalid application type!</p>";
        exit;
    }

    if (isset($sql)) {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $rural_id, $id);
        if ($stmt->execute()) {
            $stmt2 = $conn->prepare($ngoQuery);
            $stmt2->bind_param("i", $id);
            $stmt2->execute();
            $res = $stmt2->get_result();
            $row = $res->fetch_assoc();
            $ngo_id = $row['NGO_ID'] ?? null;
            $stmt2->close();

            if ($ngo_id) {
                $job_id = $type == 'job' ? $id : null;
                $scheme_id = $type == 'scheme' ? $id : null;
                $stmt3 = $conn->prepare("INSERT INTO InterestedRurals (NGO_ID, Rural_ID, Job_ID, Training_ID, Scheme_ID) VALUES (?, ?, ?, NULL, ?)");
                $stmt3->bind_param("iiii", $ngo_id, $rural_id, $job_id, $scheme_id);
                $stmt3->execute();
                $stmt3->close();
            }
            header("Location: MyInterests.php?applied=1");
            exit;
        } else {
            echo "<p style='color:red;'>Error: " . htmlspecialchars($stmt->error) . "</p>";
        }
        $stmt->close();
    }
}

$conn->close();
?>
