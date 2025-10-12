<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
echo "<pre>POST: "; print_r($_POST); 
echo "SESSION: "; print_r($_SESSION); 
echo "</pre>";
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sahyog1";

// Create DB connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if NGO is logged in
if (!isset($_SESSION['NGO_ID'])) {
    echo "<p style='color:red;'>You are not logged in as NGO!</p>";
    exit;
}

$ngo_id = $_SESSION['NGO_ID'];

// Fetch all applications for posts created by this NGO
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
<style>
body { font-family: Arial; margin: 40px; background: #f9f9f9; }
h2 { text-align:center; color:#333; }
table { width:100%; border-collapse: collapse; background:#fff; box-shadow:0 0 5px rgba(0,0,0,0.1);}
th, td { border:1px solid #ddd; padding:10px; text-align:left;}
th { background:#f2f2f2;}
</style>
</head>
<body>
<h2>Rural Users Interested in Your Posts</h2>

<?php if($result->num_rows === 0): ?>
    <p style="text-align:center; color:red;">No rural users have applied yet.</p>
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
