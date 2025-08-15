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
    $fullname = $_POST['fullname'] ?? '';
    $email = $_POST['email'] ?? '';
    $pass = $_POST['password'] ?? '';
    $mobile_number=$_POST['mobile_number'] ?? '';
     $nameofNGO=$_POST['nameofNGO'] ?? '';
      $location=$_POST['location'] ?? '';

    // Hash the password
    $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);

    // Insert into DB
    $sql = "INSERT INTO ngo_users (fullname, email, password,mobile_number,nameofNGO,location) VALUES (?, ?, ?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $fullname, $email, $hashedPassword,$mobile_number,$nameofNGO,$location);

    if ($stmt->execute()) {
        echo "Signup successful!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
$conn->close();
?>
