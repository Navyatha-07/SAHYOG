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

// If user is not logged in, redirect to NGO login
if (!isset($_SESSION['username']) || $_SESSION['usertype'] !== 'ngo') {
    header("Location: 10_NGOLogin.html");
    exit;
}

$name   = $_SESSION['username'];  // NGO fullname
$ngo_id = $_SESSION['NGO_ID'];    // NGO unique ID
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NGO Dashboard</title>
    <link rel="stylesheet" href="Styling.css"/>
</head>

<body style="overflow: hidden;">
<?php include 'nav.php'; ?>
    
    <p class="welcome">Welcome <?php echo htmlspecialchars($name); ?>,</p>
    <h1 class="heading">Quick Summary</h1>

    <div class="card-container">

        <!-- Total Schemes Posted -->
        <div class="card1">
            <a href="Posted_Schemes.php">
                <h2>Total Schemes Posted</h2>
                <p>
                    <?php
                    $q = "SELECT COUNT(*) AS total FROM scheme WHERE NGO_ID='$ngo_id'";
                    $r = mysqli_query($conn, $q);
                    echo mysqli_fetch_assoc($r)['total'];
                    ?>
                </p>
            </a>
        </div>

        <!-- Total Jobs Posted -->
        <div class="card2">
            <a href="Posted_Jobs.php">
                <h2>Total Jobs Posted</h2>
                <p>
                    <?php
                    $q = "SELECT COUNT(*) AS total FROM jobs WHERE NGO_ID='$ngo_id'";
                    $r = mysqli_query($conn, $q);
                    echo mysqli_fetch_assoc($r)['total'];
                    ?>
                </p>
            </a>
        </div>

        <!-- Total Trainings Posted -->
        <div class="card3">
            <a href="Posted_Trainings.php">
                <h2>Total Trainings Posted</h2>
                <p>
                    <?php
                    $q = "SELECT COUNT(*) AS total FROM trainings WHERE NGO_ID='$ngo_id'";
                    $r = mysqli_query($conn, $q);
                    echo mysqli_fetch_assoc($r)['total'];
                    ?>
                </p>
            </a>
        </div>

        <!-- Total Rural Users Engaged -->
        <div class="card4">
            <a href="InterestedRurals.php">
                <h2>Total Rural Users Engaged</h2>
                <p>
                    <?php
                    $q = "SELECT COUNT(DISTINCT Rural_ID) AS total
                          FROM interestedrurals
                          WHERE NGO_ID='$ngo_id'";
                    $r = mysqli_query($conn, $q);
                    echo mysqli_fetch_assoc($r)['total'];
                    ?>
                </p>
            </a>
        </div>

    </div>

    <div class="dropdown">
        <button class="DropButton">Post Opportunity</button>
        <div class="DropdownContent">
            <a href="16_Post_Schemes.html">Post Schemes</a>
            <a href="Post_Trainings.html">Post Trainings</a>
            <a href="Post_Jobs.html">Post Jobs</a>
        </div>
    </div>

</body>
</html>
