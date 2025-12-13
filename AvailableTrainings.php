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

$sql = "SELECT * FROM trainings WHERE status='active'";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Trainings</title>
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
        font-size: 2rem;
     }
        button:hover { 
            background-color: #6a0dad;
         }
    </style>
</head>
<body>
    <h2 style="font-size: 3rem;">Available Trainings</h2>
    <table>
        <tr>
            <th>Training Title</th>
            <th>Description</th>
            <th>Duration</th>
            <th>Location</th>
            <th>Mode</th>
            <th>Eligibility</th>
            <th>Skills</th>
            <th>Amount</th>
            <th>Contact</th>
            <th>Apply</th>
        </tr>
        <?php
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['Training_Title']}</td>
                        <td>{$row['Training_Description']}</td>
                        <td>{$row['Duration']}</td>
                        <td>{$row['location']}</td>
                        <td>{$row['Mode']}</td>
                        <td>{$row['Eligibility']}</td>
                        <td>{$row['Skills']}</td>
                        <td>{$row['Amount']}</td>
                        <td>{$row['Contact']}</td>
                        <td>
                            <form method='POST' action='payment_amount.php'>
                                <input type='hidden' name='type' value='training'>
                                <input type='hidden' name='id' value='{$row['Training_ID']}'>
                                <button type='submit' name='apply'>Pay & Apply</button>
                            </form>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No active trainings available.</td></tr>";
        }
        ?>
    </table>
</body>
</html>
<?php $conn->close(); ?>
