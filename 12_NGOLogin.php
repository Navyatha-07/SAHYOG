 <?php
$servername = "localhost";
$username = "root"; 
$password = "";
//<<<<<<< HEAD
$dbname = "sahyog1";
//$dbname = "sahyog1";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'] ?? '';
    $password = $_POST['password'] ?? '';
    // Prepare MySQL
    $stmt= $conn->prepare("Select password From ngo_users where fullname = ?");
    $stmt -> bind_param("s",$fullname);
    $stmt ->execute();
    $stmt -> store_result();
    if($stmt -> num_rows >0){
        $stmt -> bind_result($hashedPassword);
        $stmt->fetch();
    if(password_verify($password,$hashedPassword)){
        echo "Successfully logged in!";
        echo '<a href="14_NGO_dashboard.html"><button type="button">Go to Dashbaord</button></a>';
    }
    else {
        echo "Incorrect Credentials";
    }
}
    else{
        echo "user not found";
    }
    $stmt->close();
}
$conn->close();
?>
