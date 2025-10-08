<?php
echo"<pre>";
print_r($_SESSION);
echo "</pre>";
exit;
session_start();
<<<<<<< HEAD
error_reporting(E_ALL);
ini_set('display_errors', 1);
if(!isset($_SESSION['RuralUser_ID'])){
    echo" Please Login First";
    exit;
}
$RuralUser_ID =$_SESSION['RuralUser_ID'];

// Connect to database
$conn = new mysqli("localhost", "root", "", "sahyog1");
=======
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sahyog1";
$conn = new mysqli($servername, $username, $password, $dbname);

>>>>>>> 504ad1220247d0bf966a9853f29f24a10842c3e5
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

<<<<<<< HEAD
// Fetch all schemes (from all NGOs)
$query = "SELECT s.*, n.fullname
          FROM scheme s 
          JOIN ngo_users n ON s.NGO_ID = n.id
          ORDER BY s.Posted_Date DESC";

$result = $conn->query($query);
if(!$result) die("Query error:".$conn -> error);
=======
if(!isset($_SESSION['Rural_ID'])) {
    echo "<p style='color:red;'>You are not logged in!</p>";
    exit;
}

$sql = "SELECT * FROM Scheme WHERE status='active'";
$result = $conn->query($sql);
>>>>>>> 504ad1220247d0bf966a9853f29f24a10842c3e5
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
<<<<<<< HEAD
<h2>Available Schemes</h2>

<?php
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='scheme'>";
        echo "<h3>" . htmlspecialchars($row['Scheme_Title']) . "</h3>";
        echo "<p>" . nl2br(htmlspecialchars($row['Scheme_Description'])) . "</p>";
        echo "<div class='details'>";
        echo "📍 Location: " . htmlspecialchars($row['location']) . "<br>";
        echo "🏷 Category: " . htmlspecialchars($row['Category']) . "<br>";
        echo "📅 Scheme Date: " . htmlspecialchars($row['Scheme_Date']) . "<br>";
        echo "🏛 Posted by: " . htmlspecialchars($row['fullname']) . "<br>";
        echo "</div></div>";

        echo "<form method ='POST' action = 'ApplyScheme.php'>";
        echo "<input type ='hidden' name='Scheme_ID' value ='".$row['Scheme_ID']."'>";
        echo " <button type ='submit' > Apply</button>";
        echo "</form>";
    }
} else {
    echo "<p>No schemes available right now.</p>";
}
$conn->close();
?>
=======
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
>>>>>>> 504ad1220247d0bf966a9853f29f24a10842c3e5
</body>
</html>
<?php $conn->close(); ?>
