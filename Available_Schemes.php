<?php
session_start();

$conn = new mysqli("localhost", "root", "", "sahyog1");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['Rural_ID'])) {
    echo "<p style='color:red;'>You are not logged in!</p>";
    exit;
}

$Rural_ID = $_SESSION['Rural_ID'];

$sql = "SELECT * FROM scheme WHERE status='active'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>Available Schemes</title>
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
    padding: 18px;
    font-size: 28px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    text-align: left;
}

/* Table cells */
td {
    padding: 18px;
    border-bottom: 1px solid #eee;
    vertical-align: top;
    font-size: 24px;
    font-weight: bold;
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
 button {
    background-color: #4B0082;
    color: white;
    padding: 14px 25px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1.5rem;
}
button:hover {
    background-color: #6a0dad;
}
button.applied,
button:disabled {
    background-color: #aaa;
    color: #444;
    cursor: not-allowed;
}
</style>
</head>
<body>

<h2>Available Schemes</h2>

<table border="1" cellpadding="10">
<tr>
    <th>Title</th>
    <th>Description</th>
    <th>Location</th>
    <th>Date</th>
    <th>Eligibility</th>
    <th>Category</th>
    <th>Apply</th>
</tr>

<?php
while ($row = $result->fetch_assoc()) {

    $check = $conn->prepare(
        "SELECT 1 FROM SchemeApplications 
         WHERE Scheme_ID = ? AND Rural_ID = ?"
    );
    $check->bind_param("ii", $row['Scheme_ID'], $Rural_ID);
    $check->execute();
    $check->store_result();
    $alreadyApplied = $check->num_rows > 0;
    $check->close();

    echo "<tr>
        <td>{$row['Scheme_Title']}</td>
        <td>{$row['Scheme_Description']}</td>
        <td>{$row['location']}</td>
        <td>{$row['Scheme_Date']}</td>
        <td>{$row['Eligibility']}</td>
        <td>{$row['Category']}</td>
        <td>";

    if ($alreadyApplied) {
        echo "<button class='applied' disabled>Applied</button>";
    } else {
        echo "
            <form method='POST' action='ApplyScheme.php'>
                <input type='hidden' name='Scheme_ID' value='{$row['Scheme_ID']}'>
                <button type='submit' name='apply'>Apply</button>
            </form>
        ";
    }

    echo "</td></tr>";
}
?>

</table>
</body>
</html>
