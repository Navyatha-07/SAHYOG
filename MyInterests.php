<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// --- Login check ---
if(!isset($_SESSION['Rural_ID'])){
    echo "<p style='color:red;'>You are not logged in!</p>";
    exit;
}

$Rural_ID = $_SESSION['Rural_ID'];

// --- Database connection ---
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sahyog1";

$conn = new mysqli($servername, $username, $password, $dbname);
if($conn->connect_error) die("Connection failed: ".$conn->connect_error);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Interests</title>
</head>
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
<h1>My Applied Opportunities</h1>

<!-- Applied Schemes -->
<h2>Applied Schemes</h2>
<?php
$scheme_sql = $conn->prepare("
    SELECT s.Scheme_ID, s.Scheme_Title, s.Scheme_Description, s.location, s.Scheme_Date, s.Eligibility, s.Category
    FROM scheme s
    INNER JOIN applications a ON a.Scheme_ID = s.Scheme_ID
    WHERE a.Rural_ID = ?
    ORDER BY s.Posted_Date DESC
");
$scheme_sql->bind_param("i", $Rural_ID);
$scheme_sql->execute();
$scheme_result = $scheme_sql->get_result();

if($scheme_result->num_rows > 0){
    echo "<table border='1' cellpadding='5'>
    <tr><th>Title</th><th>Description</th><th>Location</th><th>Date</th><th>Eligibility</th><th>Category</th></tr>";
    while($row = $scheme_result->fetch_assoc()){
        echo "<tr>
        <td>{$row['Scheme_Title']}</td>
        <td>{$row['Scheme_Description']}</td>
        <td>{$row['location']}</td>
        <td>{$row['Scheme_Date']}</td>
        <td>{$row['Eligibility']}</td>
        <td>{$row['Category']}</td>
        </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No schemes applied yet.</p>";
}
$scheme_sql->close();
?>

<!-- Applied Jobs -->
<h2>Applied Jobs</h2>
<?php
$job_sql = $conn->prepare("
    SELECT j.Job_ID, j.Job_Title, j.Job_Description, j.location, j.Salary, j.Eligibility, j.Job_Type, j.Contact
    FROM jobs j
    INNER JOIN applications a ON a.Job_ID = j.Job_ID
    WHERE a.Rural_ID = ?
    ORDER BY j.Posted_Date DESC
");
$job_sql->bind_param("i", $Rural_ID);
$job_sql->execute();
$job_result = $job_sql->get_result();

if($job_result->num_rows > 0){
    echo "<table border='1' cellpadding='5'>
    <tr><th>Title</th><th>Description</th><th>Location</th><th>Salary</th><th>Eligibility</th><th>Job Type</th><th>Contact</th></tr>";
    while($row = $job_result->fetch_assoc()){
        echo "<tr>
        <td>{$row['Job_Title']}</td>
        <td>{$row['Job_Description']}</td>
        <td>{$row['location']}</td>
        <td>{$row['Salary']}</td>
        <td>{$row['Eligibility']}</td>
        <td>{$row['Job_Type']}</td>
        <td>{$row['Contact']}</td>
        </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No jobs applied yet.</p>";
}
$job_sql->close();
?>

<!-- Applied Trainings -->
<h2>Applied Trainings</h2>
<?php
$training_sql = $conn->prepare("
    SELECT t.Training_ID, t.Training_Title, t.Training_Description, t.location, t.Training_Date, t.Duration, t.Mode, t.Eligibility, t.Skills, t.Contact
    FROM trainings t
    INNER JOIN applications a ON a.Training_ID = t.Training_ID
    WHERE a.Rural_ID = ?
    ORDER BY t.Posted_Date DESC
");
$training_sql->bind_param("i", $Rural_ID);
$training_sql->execute();
$training_result = $training_sql->get_result();

if($training_result->num_rows > 0){
    echo "<table border='1' cellpadding='5'>
    <tr><th>Title</th><th>Description</th><th>Location</th><th>Date</th><th>Duration</th><th>Mode</th><th>Eligibility</th><th>Skills</th><th>Contact</th></tr>";
    while($row = $training_result->fetch_assoc()){
        echo "<tr>
        <td>{$row['Training_Title']}</td>
        <td>{$row['Training_Description']}</td>
        <td>{$row['location']}</td>
        <td>{$row['Training_Date']}</td>
        <td>{$row['Duration']}</td>
        <td>{$row['Mode']}</td>
        <td>{$row['Eligibility']}</td>
        <td>{$row['Skills']}</td>
        <td>{$row['Contact']}</td>
        </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No trainings applied yet.</p>";
}
$training_sql->close();

$conn->close();
?>
</body>
</html>
