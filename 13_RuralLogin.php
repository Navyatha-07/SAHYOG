 <?php
$servername = "localhost";
$username = "root"; 
$password = "Navya@123";
$dbname = "sahyog1";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $FullName = trim($_POST['FullName'] ?? '');
    $pass = trim($_POST['Password'] ?? '');
    // Prepare MySQL
    $stmt= $conn->prepare("Select password FROM rural_users where FullName = ?");
    $stmt -> bind_param("s",$FullName);
    $stmt ->execute();
    $stmt -> store_result();
    if($stmt -> num_rows >0){
        $stmt -> bind_result($hashedPassword);
        $stmt->fetch();
    if(password_verify($pass,$hashedPassword)){
        echo "Successfully logged in! <br><br>";
        echo '<a href="Rural_dashboard.html"><button type="button">Go to Dashbaord</button></a>';
    }
    else {
        echo "Incorrect Credentials";
    }
}
    else{
        echo "user not found";
    }
    $stmt->close();
$conn->close();
}
?>
