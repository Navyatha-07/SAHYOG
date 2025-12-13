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
<style>
body {
    margin: 0;
    padding: 30px;
    font-family: Arial, Helvetica, sans-serif;
    background: #f2f6fc;
    color: #2d2d44;
}

/* Heading */
h2 {
    text-align: center;
    margin-bottom: 25px;
    font-size: 32px;
    letter-spacing: 1px;
}

/* Success message */
p[style*="color: green"] {
    text-align: center;
    font-weight: 600;
    background: #e6f7ee;
    padding: 12px;
    border-radius: 8px;
    margin-bottom: 25px;
}

/* Table */
table {
    width: 100%;
    border-collapse: collapse;
    background: #ffffff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 6px 20px rgba(0,0,0,0.08);
}

/* Table header */
th {
    background: #4B0082;
    color: #ffffff;
    padding: 14px;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Table cells */
td {
    padding: 14px;
    border-bottom: 1px solid #eee;
    vertical-align: top;
    font-size: 14px;
}

/* Zebra rows */
tr:nth-child(even) {
    background-color: #f8f9ff;
}

/* Hover effect */
tr:hover {
    background-color: #eef1ff;
}

/* Actions column */
td:last-child {
    white-space: nowrap;
}

/* Links */
a {
    text-decoration: none;
    font-weight: 600;
    margin-right: 12px;
}

/* Edit link */
a[href*="Edit.php"] {
    color: #1a73e8;
}

/* Delete link */
a[href*="Delete.php"] {
    color: #d93025;
}

/* Hover links */
a:hover {
    opacity: 0.8;
}

/* No data text */
p {
    text-align: center;
    font-size: 28px;
    margin-top: 30px;
}
</style>
</head>
<body>
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
