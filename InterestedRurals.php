<?php
session_start();
error_reporting(0);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sahyog1";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['NGO_ID'])) {
    echo "<p style='color:red; text-align:center;'>You are not logged in!</p>";
    exit;
}

$NGO_ID = $_SESSION['NGO_ID'];

$sql = "SELECT a.*, 
       r.Rural_Name,
       CASE 
           WHEN a.Type='scheme' THEN s.Scheme_Title
           WHEN a.Type='job' THEN j.Job_Title
           WHEN a.Type='training' THEN t.Training_Title
       END AS Title
FROM applications a
LEFT JOIN rural r ON a.Rural_ID = r.Rural_ID
LEFT JOIN scheme s ON (a.Type='scheme' AND a.Item_ID=s.Scheme_ID)
LEFT JOIN jobs j ON (a.Type='job' AND a.Item_ID=j.Job_ID)
LEFT JOIN training t ON (a.Type='training' AND a.Item_ID=t.Training_ID)
WHERE a.NGO_ID=? 
ORDER BY a.Applied_Date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $NGO_ID);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Interested Rural Users</title>
<style>
body { font-family: Arial; margin: 20px; background: #f4f4f4; }
h1 { color: #4B0082; text-align: center; }
table { width: 100%; border-collapse: collapse; background: #fff; }
th, td { border: 1px solid #ddd; padding: 10px; }
th { background-color: #4B0082; color: white; }
</style>
</head>
<body>

<h1>Rural Users Who Applied</h1>
<table>
<tr>
  <th>Rural User</th>
  <th>Applied For</th>
  <th>Type</th>
  <th>Date</th>
</tr>

<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>{$row['Rural_Name']}</td>
            <td>{$row['Title']}</td>
            <td>{$row['Type']}</td>
            <td>{$row['Applied_Date']}</td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='4' style='text-align:center;'>No applications yet</td></tr>";
}
$conn->close();
?>
</table>
</body>
</html>
