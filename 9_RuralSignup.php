<?php
$servername = "localhost";
$username = "root"; // change if needed
$password = ""; // change if you set a MySQL password
$dbname = "sahyog1";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check 
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $FullName = $_POST['FullName'] ?? '';
    $Email = $_POST['Email'] ?? '';
    $pass = $_POST['Password'] ?? '';
    $MobileNumber=$_POST['MobileNumber'] ?? '';
     $Age=$_POST['Age'] ?? '';
      $location=$_POST['location'] ?? '';
      $Needs =$_POST['Needs'] ?? '';
      $Skills =$_POST['Skills'] ?? '';
    // Hash the password
    $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);
    $check = $conn -> prepare("SELECT id from rural_users WHERE MobileNumber =? OR Email=?");
    $check-> bind_param("ss",$MobileNumber,$Email);
    $check-> execute();
    $check->store_result();
    if($check -> num_rows>0){
        echo "Mobile number or email already exists.Please try again.";
    }
    else{
    // Insert into DB
    $sql = "INSERT INTO rural_users(FullName, Email, Password,MobileNumber,Age,location,Skills,Needs) VALUES (?, ?, ?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
    if($stmt == false){
        die("prepare failed".$conn->error);
    }
    $stmt->bind_param("ssssssss", $FullName, $Email, $hashedPassword,$MobileNumber,$Age,$location,$Skills,$Needs);
    if ($stmt ->execute()) {
        echo "Signup successful! <br> <br>";
        echo '<a href="Login.html"><button type="button">Go to Login</button></a>';
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
$check -> close();
}
$conn->close();
?>
