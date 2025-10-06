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

// --- Check login ---
if(!isset($_SESSION['NGO_ID'])){
    echo "<p style='color:red;'>You are not logged in!</p>";
    exit;
}

// Use the session NGO_ID directly
$NGO_ID = $_SESSION['NGO_ID'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Scheme_Title = $_POST['Scheme_Title'];
    $Scheme_Description = $_POST['Scheme_Description'];
    $location = $_POST['location'];
    $Scheme_Date = $_POST['Scheme_Date'];
    $Eligibility = $_POST['Eligibility'];
    $Category = $_POST['Category'];

    $sql = "INSERT INTO Scheme (NGO_ID, Scheme_Title, Scheme_Description, location, Scheme_Date, Eligibility, Category, status, Posted_Date)
            VALUES (?, ?, ?, ?, ?, ?, ?, 'active', NOW())";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssss", $NGO_ID, $Scheme_Title, $Scheme_Description, $location, $Scheme_Date, $Eligibility, $Category);

    if($stmt->execute()){
        $stmt->close();
        $conn->close();
        header("Location: posted_schemes.php?success=1");
        exit;
    }
    else{
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>
