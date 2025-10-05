<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ✅ Connect to database
$conn = new mysqli("localhost", "root", "", "sahyog1");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ✅ Fetch all schemes (from all NGOs)
$query = "SELECT t.*, n.fullname
          FROM trainings t
          JOIN ngo_users n ON t.NGO_ID = n.id
          ORDER BY t.Posted_Date DESC";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Available Trainings </title>
<style>
.trainings {
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 15px;
    margin: 10px 0;
    background-color: #f9f9f9;
}
.training h3 {
    margin: 0;
    color: #333;
}
.details {
    color: #555;
}
</style>
</head>
<body>
<h2>Available Tranings</h2>

<?php
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='trainings'>";
        echo "<h3>" . htmlspecialchars($row['Training_Title']) . "</h3>";
        echo "<p>" . nl2br(htmlspecialchars($row['Training_Description'])) . "</p>";
        echo "<div class='details'>";
        echo "📍 Location: " . htmlspecialchars($row['location']) . "<br>";
        echo "  Date: " . htmlspecialchars($row['Training_Date']) . "<br>";
        echo " Duration :" .htmlspecialchars($row['Duration']) . "<br>";
         echo "Mode: " . htmlspecialchars($row['Mode']) . "<br>";
          echo "Eligibility: " . htmlspecialchars($row['Eligibility']) . "<br>";
           echo "Skills : " . htmlspecialchars($row['Skills']) . "<br>";
            echo "Contact: " . htmlspecialchars($row['Contact']) . "<br>";
        echo "🏛 Posted by: " . htmlspecialchars($row['fullname']) . "<br>";
        echo "</div></div>";
    }
} else {
    echo "<p>No  Trainings available right now.</p>";
}
$conn->close();
?>
</body>
</html>
