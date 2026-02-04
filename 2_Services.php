<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Services</title>
<link rel="stylesheet" href="Styling.css"/>
</head>
<body>
<?php include 'nav.php'; ?>
    <h1 class="heading">Our Services</h1>
    <p class="welcome">We aim to empower rural communities by providing access to government schemes, job opportunities, skill trainings, and personalized support.</p>
    
    <div class="card-container">
        <div class="card1">
            <h3>Skill Training</h3>
            <p>Learn new skills to improve employment opportunities</p>
            <!-- Popup trigger -->
            <a href="#login-popup" class="know-more">Know More</a>
        </div>
        <div class="card2">
            <h3>Government Schemes</h3>
            <p>Get information about the latest government welfare schemes</p>
            <a href="#login-popup" class="know-more">Know More</a>
        </div>
        <div class="card3">
            <h3>Job Opportunities</h3>
            <p>Explore verified jobs suitable for your skills and interests.</p>
            <a href="#login-popup" class="know-more">Know More</a>
        </div>
    </div>

    <!-- Popup Modal -->
     <div id="login-popup" class="popup">
        <div class="popup-content">
            <a href="#" class="close-popup">&times;</a>
            <h2 style="font-size: 3rem;">Login Required</h2>
            <p style="font-size: 2rem; font-weight:600">You need to login, or if you are a new user, you need to sign up to know more info.</p>
            <div  class="popup-buttons">
                <a href="Login.html" class="popup-btn">Login</a>
                <a href="5_Signup.html" class="popup-btn">Sign Up</a>
            </div>
        </div>
    </div>
</body>
</html>
