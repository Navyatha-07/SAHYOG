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
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}
th, td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left;
}
th {
    background-color: #f2f2f2;
}
a {
    text-decoration: none;
    color: blue;
    margin-right: 5px;
}
a:hover {
    text-decoration: underline;
}
</style>
</head>
<body>
<h2>Your Posted Schemes</h2>
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
        <a href='Edit.php?type=scheme&id=" . $row['Scheme_ID'] . "'>✏️ Edit</a>;
                <a href='Delete.php?type=scheme&id=" . $row['Scheme_ID'] ."' onclick='return confirm(\"Are you sure you want to delete this scheme?\")'>🗑 Delete</a>
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

