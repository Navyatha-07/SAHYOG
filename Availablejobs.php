<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
if(!isset($_SESSION['username']) || $_SESSION['usertype'] != 'rural')
    {
    echo "<p style='color:red;'>You are not logged in!</p>";
    exit;
}
$rural_username = $_SESSION['username'];
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sahyog1";
$conn = new mysqli($servername, $username, $password, $dbname);
if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT Job_ID, Job_Title, Job_Description, 
location, Job_Date, Eligibility, 
Salary, Job_Type, Contact FROM jobs WHERE status='active' 
ORDER BY Posted_Date DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Available Jobs</title>
</head>
<body>
<h2  style="font-size: 3rem;">Available Jobs</h2>
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
<?php
if($result->num_rows > 0){
    echo "<table border='1' cellpadding='10'>
            <tr>
                <th>Job Title</th>
                <th>Description</th>
                <th>Location</th>
                <th>Date</th>
                <th>Eligibility</th>
                <th>Salary</th>
                <th>Job Type</th>
                <th>Contact</th>
                <th>Action</th>
            </tr>";
    while($row = $result->fetch_assoc()){
        echo "<tr>
                <td>{$row['Job_Title']}</td>
                <td>{$row['Job_Description']}</td>
                <td>{$row['location']}</td>
                <td>{$row['Job_Date']}</td>
                <td>{$row['Eligibility']}</td>
                <td>{$row['Salary']}</td>
                <td>{$row['Job_Type']}</td>
                <td>{$row['Contact']}</td>
                <td>
                    <form action='apply.php' method='POST'>
                        <input type='hidden' name='Job_ID' 
                        value='{$row['Job_ID']}'>
                        <button type='submit' name='apply'>
                        Apply</button>
                    </form>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No jobs available currently.</p>";
}
$conn->close();
?>
</body>
</html>
