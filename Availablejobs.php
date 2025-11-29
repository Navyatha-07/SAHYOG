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
<h1>Available Jobs</h1>
<style>
        table { 
            width: 90%; margin: 30px auto; border-collapse: 
            collapse; 
        }
        th, td { 
            padding: 10px; border: 1px solid #888; 
            text-align: center; 
        }
        th { 
            background: #4B0082; color: white;
         }
        tr:nth-child(even) { 
            background-color: #f2f2f2; 
        }
        button { 
            background-color: #4B0082; color: white; 
            padding: 7px 15px; border: none; border-radius: 
            5px; cursor: pointer;
         }
        button:hover { 
            background-color: #6a0dad;
         }
        h1 { 
            text-align: center; color: #4B0082; 
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
