 <?php
$servername = "localhost";
$username = "root"; 
$password = "";

$dbname = "sahyog1";


//>>>>>>> e094d4ee8d40af059732fcb0788e25e0864e793d
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
else{
    echo " Connected successfully";
}
?>