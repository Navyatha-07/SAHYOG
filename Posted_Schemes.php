<?php 
session_start();
error_reporting(E_ALL);
ini_set('display_errors',1);

if(!isset($_SESSION['NGO_ID'])){
    echo "<p style='color:red;'>You are not logged in!</p>";
    exit;
}

$NGO_ID = $_SESSION['NGO_ID'];

$conn = new mysqli("localhost","root","","sahyog1");
if($conn->connect_error) die("Connection failed: ".$conn->connect_error);

$stmt = $conn->prepare("SELECT * FROM Scheme WHERE NGO_ID = ? ORDER BY Posted_Date DESC");
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
/* Base page */
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

<h2 style="font-size: 4rem;"> Your Posted Schemes</h2>

<?php
if(isset($_GET['success']) && $_GET['success'] == 1){
    echo '<p style="color: green;">Scheme Posted Successfully!</p>';
}

if ($result->num_rows > 0) {

    echo "<table>";
    echo "<tr>
            <th>Scheme Title</th>
            <th>Scheme Date</th>
            <th>Description</th>
            <th>Location</th>
            <th>Category</th>
            <th>Eligibility</th>
            <th>Actions</th>
          </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['Scheme_Title']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Scheme_Date']) . "</td>";
        echo "<td>" . nl2br(htmlspecialchars($row['Scheme_Description'])) . "</td>";
        echo "<td>" . htmlspecialchars($row['location']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Category']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Eligibility']) . "</td>";
        echo "<td>
                <a href='Edit.php?type=scheme&id=" . $row['Scheme_ID'] . "'>✏️ Edit</a>
                <a href='Delete.php?type=scheme&id=" . $row['Scheme_ID'] . "' 
                   onclick='return confirm(\"Are you sure you want to delete this scheme?\")'>🗑 Delete</a>
              </td>";
        echo "</tr>";
    }

    echo "</table>";

} else {
    echo "<p>No schemes posted yet.</p>";
}

$stmt->close();
$conn->close();
?>

</body>
</html>
