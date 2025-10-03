<?php
$servername = "localhost";
$username = "root"; 
$password = "";
$dbname = "sahyog1";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'] ;
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $mobile_number=$_POST['mobile_number'];
     $nameofNGO=$_POST['nameofNGO'];
      $location=$_POST['location'];
    // Hash the password
    $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);
    $check = $conn -> prepare("SELECT id from ngo_users WHERE mobile_number =? OR email=?");
    $check-> bind_param("ss",$mobile_number,$email);
    $check-> execute();
    $check->store_result();
    if($check -> num_rows>0){
        echo "Mobile number or email already exists.Please try again.";
    }
    else{
    // Insert into DB
    $sql = "INSERT INTO ngo_users (fullname, email, password,mobile_number,nameofNGO,location) VALUES (?, ?, ?,?,?,?)";
    $stmt = $conn->prepare($sql);
    if($stmt == false){
        die("prepare failed".$conn->error);
    }
    $stmt->bind_param("ssssss", $fullname, $email, $hashedPassword,$mobile_number,$nameofNGO,$location);
    if ($stmt ->execute()) {
        echo "Signup successful! <br><br>";
        echo '<a href="10_NGOLogin.html"><button type="button">Go to Login</button></a>';
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
$check->close();
}
$conn->close();
?>
