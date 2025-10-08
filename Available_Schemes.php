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

if(!isset($_SESSION['Rural_ID'])) {
    echo "<p style='color:red;'>You are not logged in!</p>";
    exit;
}

$sql = "SELECT * FROM Scheme WHERE status='active'";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Schemes</title>
    <style>
        table { width: 90%; margin: 30px auto; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #888; text-align: center; }
        th { background: #4B0082; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        button { background-color: #4B0082; color: white; padding: 7px 15px; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background-color: #6a0dad; }
        h1 { text-align: center; color: #4B0082; }
    </style>
</head>
<body>
    <h1>Available Schemes</h1>
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
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['Scheme_Title']}</td>
                        <td>{$row['Scheme_Description']}</td>
                        <td>{$row['location']}</td>
                        <td>{$row['Scheme_Date']}</td>
                        <td>{$row['Eligibility']}</td>
                        <td>{$row['Category']}</td>
                        <td>
                            <form method='POST' action='Apply.php'>
                                <input type='hidden' name='type' value='scheme'>
                                <input type='hidden' name='id' value='{$row['Scheme_ID']}'>
                                <button type='submit' name='apply'>Apply</button>
                            </form>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No active schemes available.</td></tr>";
        }
        ?>
    </table>
</body>
</html>
<?php $conn->close(); ?>
