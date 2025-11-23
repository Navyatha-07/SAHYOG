<?php
session_start();

// If user is not logged in, redirect to NGO login
if (!isset($_SESSION['username']) || $_SESSION['usertype'] !== 'ngo') {
    header("Location: 10_NGOLogin.html");
    exit;
}

$name = $_SESSION['username']; // NGO fullname from login
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NGO Dashboard</title>
    <link rel="stylesheet" href="stylesheet.css"/>
</head>
<body>

    <p>WELCOME <?php echo htmlspecialchars($name); ?>,</p>
    <h1>Quick Summary</h1>

    <div class="card-container">
        <div class="card1">
            <a href="Posted_Schemes.php">
                <h2>Total Schemes Posted</h2>
                <p>Numbers</p>
            </a>
        </div>

        <div class="card2">
            <a href="Posted_Jobs.php">
                <h2>Total Jobs Posted</h2>
                <p>Numbers</p>
            </a>
        </div>

        <div class="card3">
            <a href="Posted_Trainings.php">
                <h2>Total Trainings Posted</h2>
                <p>Numbers</p>
            </a>
        </div>

        <div class="card4">
            <a href="InterestedRurals.php">
                <h2>Total Rural Users Engaged</h2>
                <p>Numbers</p>
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
