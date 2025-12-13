 <?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sahyog1";

$conn = new mysqli($servername, $username, $password, $dbname);
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
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Available Schemes</title>

<style>
body {
    margin: 0;
    padding: 30px;
    font-family: Arial, Helvetica, sans-serif;
    background: #f2f6fc;
    color: #2d2d44;
}

h2 {
    text-align: center;
    margin-bottom: 25px;
    font-size: 32px;
}

table {
    width: 100%;
    border-collapse: collapse;
    background: #ffffff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 6px 20px rgba(0,0,0,0.08);
}

th {
    background: #4B0082;
    color: #ffffff;
    padding: 18px;
    font-size: 24px;
    text-align: left;
}

td {
    padding: 18px;
    border-bottom: 1px solid #eee;
    font-size: 18px;
    vertical-align: top;
}

tr:nth-child(even) {
    background-color: #f8f9ff;
}

button {
    background-color: #4B0082;
    color: white;
    padding: 14px 25px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 18px;
    width: 100%;
}

button:hover {
    background-color: #6a0dad;
}

/* Applied / disabled state */
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

<table>
<tr>
    <th>Scheme Title</th>
    <th>Description</th>
    <th>Location</th>
    <th>Date</th>
    <th>Eligibility</th>
    <th>Category</th>
    <th>Apply</th>
</tr>

<?php
if ($result && $result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {

        // Check if already applied
        $check = $conn->prepare(
            "SELECT 1 FROM scheme_applications 
             WHERE Scheme_ID = ? AND User_ID = ?"
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
                <form method='POST' action='Apply.php'>
                    <input type='hidden' name='type' value='scheme'>
                    <input type='hidden' name='id' value='{$row['Scheme_ID']}'>
                    <button type='submit' name='apply'>Apply</button>
                </form>
            ";
        }

        echo "</td></tr>";
    }

} else {
    echo "<tr><td colspan='7'>No active schemes available.</td></tr>";
}

$conn->close();
?>

</table>

</body>
</html>
