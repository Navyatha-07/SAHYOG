<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sahyog1";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (!isset($_SESSION['NGO_ID'])) {
    echo "<p style='color:red;'>You are not logged in as NGO!</p>";
    exit;
}
$ngo_id = $_SESSION['NGO_ID'];
$sql = "
SELECT 
    r.FullName,
    r.Email,
    r.Location,
    a.Applied_On,
    CASE a.Type
        WHEN 'jobs' THEN j.Job_Title
        WHEN 'training' THEN t.Training_Title
        WHEN 'scheme' THEN s.Scheme_Title
    END AS PostTitle,
    a.Type AS PostType
FROM Applications a
LEFT JOIN rural_users r ON a.Rural_ID = r.ID
LEFT JOIN jobs j ON a.App_ID = j.Job_ID AND a.Type = 'jobs'
LEFT JOIN Trainings t ON a.App_ID = t.Training_ID AND a.Type = 'training'
LEFT JOIN scheme s ON a.App_ID = s.Scheme_ID AND a.Type = 'scheme'
WHERE ( (a.Type='jobs' AND j.NGO_ID = ?) 
        OR (a.Type='training' AND t.NGO_ID = ?) 
        OR (a.Type='scheme' AND s.NGO_ID = ?) )
ORDER BY a.Applied_On DESC
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $ngo_id, $ngo_id, $ngo_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Interested Rurals</title>
<link rel="stylesheet" href="Styling.css"/>
</head>
<body class="tables">
<h2 style="font-size: 4rem;">Rural Users Interested in Your Posts</h2>
<?php if($result->num_rows === 0): ?>
    <p style="text-align:center; color:red;">
        No rural users have applied yet.</p>
<?php else: ?>
<table>
<tr>
    <th>Name</th>
    <th>Email ID</th>
    <th>Location</th>
    <th>Post Type</th>
    <th>Post Title</th>
    <th>Applied On</th>
</tr>
<?php while($row = $result->fetch_assoc()): ?>
<tr>
    <td><?php echo htmlspecialchars($row['FullName']); ?></td>
    <td><?php echo htmlspecialchars($row['Email']); ?></td>
    <td><?php echo htmlspecialchars($row['Location']); ?></td>
    <td><?php echo ucfirst($row['PostType']); ?></td>
    <td><?php echo htmlspecialchars($row['PostTitle']); ?></td>
    <td><?php echo htmlspecialchars($row['Applied_On']); ?></td>
</tr>
<?php endwhile; ?>
</table>
<?php endif; ?>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
