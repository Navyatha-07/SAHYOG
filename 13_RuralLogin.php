 <?php
$servername = "localhost";
$username = "root"; // change if needed
$password = "Navya@123"; // change if you set a MySQL password
$dbname = "SAHYOG1";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $FullName = $_POST['FullName'] ?? '';
    $pass = $_POST['Password'] ?? '';
    // Prepare MySQL
    $stmt= $conn->prepare("Select password From rural_users where FULLNAME = ?");
    $stmt -> bind_param("s",$FullName);
    $stmt ->execute();
    $stmt -> store_result();
    if($stmt -> num_rows >0){
        $stmt -> bind_result($hashedPassword);
        $stmt->fetch();
    if(password_verify($pass,$hashedPassword)){
        echo "Successfully logged in!";
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
