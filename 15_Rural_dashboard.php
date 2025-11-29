<?php
session_start();
if(!isset($_SESSION['username'])){
    header("Location: 13_RuralLogin.php");
    exit;
}
$name = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rural Dashboard</title>
    <link rel="stylesheet" href="stylesheet.css"/>
</head>
<body>
    
    <p>Welcome <?php echo htmlspecialchars($name); ?>,</p>
    <h1> Quick Summary</h1>

    <div class="card-container">
        <div class="card1">
           <a href="Available_Schemes.php"> <h2>Available Schemes</h2></a>
           <p>numbers</p>
        </div>

        <div class="card2">
            <a href="AvailableTrainings.php"><h2>Available Trainings</h2></a>
            <p>numbers</p>
        </div>

        <div class="card3">
            <a href="Availablejobs.php"><h2>Available Jobs</h2></a>
            <p>numbers</p>
        </div>

        <div class="card4">
            <a href="MyInterests.php"><h2>My Interests</h2></a>
            <p>numbers</p>
        </div>
    </div>

    <br>
    <a href="logout.php"><button>Logout</button></a>

</body>
</html>
