<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors',1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sahyog1";

$conn = new mysqli($servername,$username,$password,$dbname);
if($conn->connect_error) die("Connection failed: ".$conn->connect_error);

$error = '';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT id, fullname, password FROM ngo_users WHERE fullname = ?");
    $stmt->bind_param("s",$username);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_rows == 1){
        $stmt->bind_result($NGO_ID, $fullname, $hashedPassword);
        $stmt->fetch();

        if(password_verify($password, $hashedPassword)){
            $_SESSION['NGO_ID'] = $NGO_ID;
            $_SESSION['username'] = $fullname;
            $_SESSION['usertype'] = 'ngo';

            header("Location: 14_NGO_dashboard.php");
            exit;
        } else {
            $error = "Invalid password";
        }
    } else {
        $error = "NGO not found";
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>NGO Login</title>
</head>
<body>
<h2>Login</h2>
<?php if($error) echo "<p style='color:red;'>$error</p>"; ?>
<form method="POST">
    <input type="text" name="username" placeholder="Full Name" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit">Login</button>
</form>
</body>
</html>
