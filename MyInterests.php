<?php 
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// --- Redirect if not logged in ---
if(!isset($_SESSION['Rural_ID'])){
    header("Location: 15_Rural_dashboard.html");
    exit;
}

$Rural_ID = $_SESSION['Rural_ID'];

// --- Database connection ---
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sahyog1";

$conn = new mysqli($servername, $username, $password, $dbname);
if($conn->connect_error)
     die("Connection failed: ".$conn->connect_error);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Interests</title>
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
<h2 style="font-size: 3rem;">My Applied Opportunities</h2>

<?php
// --- Applied Schemes ---
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
    echo "<h2>Applied Schemes</h2><table>
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

// --- Applied Jobs ---
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
    echo "<h2>Applied Jobs</h2><table>
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

// --- Applied Trainings ---
$training_sql = $conn->prepare("
    SELECT t.Training_ID, t.Training_Title, t.Training_Description, t.location, t.Training_Date, t.Duration, t.Mode, t.Eligibility, t.Skills, t.Contact,
           p.Method, p.Amount
    FROM training_applications a
    INNER JOIN trainings t ON a.Training_ID = t.Training_ID
    LEFT JOIN payment p ON a.Training_ID = p.Training_ID AND a.Rural_ID = p.Rural_ID
    WHERE a.Rural_ID = ?
    ORDER BY t.Posted_Date DESC
");
$training_sql->bind_param("i", $Rural_ID);
$training_sql->execute();
$training_result = $training_sql->get_result();

if($training_result->num_rows > 0){
    echo "<h2>Applied Trainings</h2><table>
    <tr>
    <th>Title</th>
    <th>Description</th>
    <th>Location</th>
    <th>Date</th>
    <th>Duration</th>
    <th>Mode</th>
    <th>Eligibility</th>
    <th>Skills</th>
    <th>Contact</th>
    <th>Paid Via</th>
    </tr>";
    while($row = $training_result->fetch_assoc()){
        $method = $row['Method'] ?? 'N/A';
        $amount = $row['Amount'] ?? '0';
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
        <td>{$method} (₹{$amount})</td>
        </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No trainings applied yet.</p>";
}
$training_sql->close();

$conn->close();
?>

<br><a href="15_Rural_dashboard.php">Back to Dashboard</a>
</body>
</html>
