<?php 
session_start();
<<<<<<< HEAD
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "sahyog1";

$conn = new mysqli($servername, $username, $password, $dbname);
=======
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ✅ Check login
if (!isset($_SESSION['NGO_ID'])) {
    header("Location: login.php");
    exit;
}

$NGO_ID = $_SESSION['NGO_ID'];

// ✅ Connect to DB
$conn = new mysqli("localhost", "root", "", "sahyog1");
>>>>>>> 72247572f367d862f5fabe0c6a00e165d56937c2
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

<<<<<<< HEAD
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

=======
// ✅ Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['Scheme_Title'];
    $description = $_POST['Scheme_Description'];
    $location = $_POST['location'];
    $category = $_POST['Category'];
    $scheme_date = $_POST['Scheme_Date'];
    $Eligibility = $_POST['Eligibility'];

    $stmt = $conn->prepare("INSERT INTO scheme (NGO_ID, Scheme_Title, Scheme_Description, location, Category, Scheme_Date, Posted_Date)
                            VALUES (?, ?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("isssss", $NGO_ID, $title, $description, $location, $category, $scheme_date);

    if ($stmt->execute()) {
        header("Location: Posted_Schemes.php?success=1");
        exit;
    } else {
        echo "❌ Error inserting scheme: " . $stmt->error;
    }

    $stmt->close();
}
>>>>>>> 72247572f367d862f5fabe0c6a00e165d56937c2
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Post a Scheme</title>
</head>
<body>
<h2>Post a New Scheme</h2>

<form method="POST" action="">
    <label>Scheme Title:</label><br>
    <input type="text" name="Scheme_Title" required><br><br>

    <label>Scheme Description:</label><br>
    <textarea name="Scheme_Description" required></textarea><br><br>

    <label>Location:</label><br>
    <input type="text" name="Location" required><br><br>

    <label>Category:</label><br>
    <input type="text" name="Category" required><br><br>

    <label>Scheme Date:</label><br>
    <input type="date" name="Scheme_Date" required><br><br>

    <button type="submit">Post Scheme</button>
</form>

</body>
</html>
