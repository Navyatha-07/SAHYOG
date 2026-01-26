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

if (!isset($_SESSION['username']) || $_SESSION['usertype'] !== 'rural') {
    header("Location: 13_RuralLogin.php");
    exit;
}

$name     = $_SESSION['username'];
$rural_id = $_SESSION['Rural_ID'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rural Dashboard</title>
    <link rel="stylesheet" href="Styling.css"/>
</head>

<body>

<p class="welcome">Welcome <?php echo htmlspecialchars($name); ?>,</p>
<h1 class="heading">Quick Summary</h1>

<div class="card-container">

    <!-- Available Schemes -->
    <div class="card1">
        <a href="Available_Schemes.php">
            <h2>Available Schemes</h2>
            <p>
                <?php
                $q = "SELECT COUNT(*) AS total FROM scheme";
                $r = mysqli_query($conn, $q);
                echo mysqli_fetch_assoc($r)['total'];
                ?>
            </p>
        </a>
    </div>

    <!-- Available Trainings -->
    <div class="card2">
        <a href="AvailableTrainings.php">
            <h2>Available Trainings</h2>
            <p>
                <?php
                $q = "SELECT COUNT(*) AS total FROM trainings";
                $r = mysqli_query($conn, $q);
                echo mysqli_fetch_assoc($r)['total'];
                ?>
            </p>
        </a>
    </div>

    <!-- Available Jobs -->
    <div class="card3">
        <a href="Availablejobs.php">
            <h2>Available Jobs</h2>
            <p>
                <?php
                $q = "SELECT COUNT(*) AS total FROM jobs";
                $r = mysqli_query($conn, $q);
                echo mysqli_fetch_assoc($r)['total'];
                ?>
            </p>
        </a>
    </div>

    <!-- My Interests -->
    <div class="card4">
        <a href="MyInterests.php">
            <h2>My Interests</h2>
            <p>
                <?php
                $q = "SELECT COUNT(*) AS total 
                      FROM interestedrurals 
                      WHERE Rural_ID='$rural_id'";
                $r = mysqli_query($conn, $q);
                echo mysqli_fetch_assoc($r)['total'];
                ?>
            </p>
        </a>
    </div>

</div>

<br>

<a href="1_MainPage.html">
<button style=" 
    margin-top: 15px;
    margin-left: 50px;
    padding: 36px 80px;
    background-color: #F26A2E;
    color: white;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    font-size: 3rem;
">
Logout
</button>
</a>

</body>
</html>
