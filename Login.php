<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors',1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sahyog1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if($conn->connect_error){
    die("Connection failed: ".$conn->connect_error);
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username_input = $_POST['username'] ?? '';
    $password_input = $_POST['password'] ?? '';

    // ===== NGO Users Login =====
    $stmt = $conn->prepare("SELECT id, fullname, password FROM ngo_users WHERE fullname = ?");
    $stmt->bind_param("s", $username_input);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_rows === 1){
        $stmt->bind_result($NGO_ID, $fullname, $hashedPassword);
        $stmt->fetch();

        if(password_verify($password_input, $hashedPassword)){
            $_SESSION['NGO_ID'] = $NGO_ID;
            $_SESSION['username'] = $fullname;
            $_SESSION['usertype'] = 'ngo';
            $stmt->close();
            $conn->close();
            header("Location: 14_NGO_dashboard.php");
            exit;
        } else {
            $error = "Invalid Username or Password";
        }
    }
    $stmt->close();

    // ===== Rural Users Login =====
    $stmt = $conn->prepare("SELECT id, FullName, password FROM rural_users WHERE FullName = ?");
    $stmt->bind_param("s", $username_input);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_rows === 1){
        $stmt->bind_result($Rural_ID, $FullName, $hashedPassword);
        $stmt->fetch();

        if(password_verify($password_input, $hashedPassword)){
            $_SESSION['username'] = $FullName;
            $_SESSION['usertype'] = 'rural';
            $_SESSION['Rural_ID'] = $Rural_ID;
            $stmt->close();
            $conn->close();
            header("Location: 15_Rural_dashboard.php");
            exit;
        } else {
            $error = "Invalid Username or Password";
        }
    }

    if(!isset($error)){
        $error = "Username not found";
    }

    $stmt->close();
    $conn->close();
}
?>


<?php
if(isset($error)){
    echo '<p style="color:red;">'.$error.'</p>';
}
?>
