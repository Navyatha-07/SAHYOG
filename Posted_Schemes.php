<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

<<<<<<< HEAD
if(!isset($_SESSION['NGO_ID'])){
    echo "<p style='color:red;'>You are not logged in!</p>";
=======
if (!isset($_SESSION['NGO_ID'])) {
    header("Location: login.php");
>>>>>>> 72247572f367d862f5fabe0c6a00e165d56937c2
    exit;
}

$NGO_ID = $_SESSION['NGO_ID'];

<<<<<<< HEAD
$conn = new mysqli("localhost","root","","sahyog1");
if($conn->connect_error) die("Connection failed: ".$conn->connect_error);

$stmt = $conn->prepare("SELECT * FROM Scheme WHERE NGO_ID = ? ORDER BY Posted_Date DESC");
=======
$conn = new mysqli("localhost", "root", "", "sahyog1");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT * FROM scheme WHERE NGO_ID = ? ORDER BY Posted_Date DESC");
>>>>>>> 72247572f367d862f5fabe0c6a00e165d56937c2
$stmt->bind_param("i", $NGO_ID);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Your Posted Schemes</title>
<style>
.scheme {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 10px;
    margin: 10px 0;
}
.icons {
    margin-top: 5px;
}
.icons a {
    margin-right: 10px;
    text-decoration: none;
    color: blue;
}
</style>
</head>
<body>
<h2>Your Posted Schemes</h2>

<?php
if (isset($_GET['success']) && $_GET['success'] == 1) {
    echo '<p style="color:green;"> Scheme Posted Successfully!</p>';
}

<<<<<<< HEAD
if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $title = isset($row['Scheme_Title']) ? $row['Scheme_Title'] : '';
        $desc = isset($row['Scheme_Description']) ? $row['Scheme_Description'] : '';
        $location = isset($row['location']) ? $row['location'] : '';
        $category = isset($row['Category']) ? $row['Category'] : '';
        $date = isset($row['Scheme_Date']) ? $row['Scheme_Date'] : '';

        echo "<b>$title</b> ($date)<br>";
        echo "$desc<br>";
        echo "Location: $location | Category: $category<br><hr>";
=======
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='scheme'>";
        echo "<b>{$row['Scheme_Title']}</b> ({$row['Scheme_Date']})<br>";
        echo nl2br(htmlspecialchars($row['Scheme_Description'])) . "<br>";
        echo "📍 Location: {$row['location']} | 🏷 Category: {$row['Category']}<br>";
        echo "Eligibility : {$row['Eligibility']} <br>";
        echo "<div class='icons'>
                <a href='edit_scheme.php?id={$row['Scheme_ID']}'>✏️ Edit</a>
                <a href='delete_scheme.php?id={$row['Scheme_ID']}' onclick='return confirm(\"Are you sure you want to delete this scheme?\")'>🗑 Delete</a>
              </div>";
        echo "</div><hr>";
>>>>>>> 72247572f367d862f5fabe0c6a00e165d56937c2
    }
} else {
    echo "<p>No posted schemes yet.</p>";
}

$stmt->close();
$conn->close();
?>
</body>
</html>

