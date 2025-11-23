<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sahyog1";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $FullName = trim($_POST['FullName']);
    $pass = trim($_POST['Password']);

    $stmt = $conn->prepare("SELECT ID, FullName, password FROM rural_users WHERE FullName = ?");
    $stmt->bind_param("s", $FullName);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($ID, $dbFullName, $hashedPassword);
        $stmt->fetch();

        if (password_verify($pass, $hashedPassword)) {
            $_SESSION['RURAL_ID'] = $ID;
            $_SESSION['username'] = $dbFullName;
            $_SESSION['usertype'] = 'rural';

            header("Location: 15_Rural_dashboard.php");
            exit;
        } else {
            $error = "Incorrect Password!";
        }
    } else {
        $error = "User Not Found!";
    }
    $stmt->close();
}
$conn->close();
?>
