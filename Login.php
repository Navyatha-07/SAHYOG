<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors',1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sahyog1";

$conn = new mysqli($servername, $username, $password, $dbname);
if($conn->connect_error){
    die("Connection failed: ".$conn->connect_error);
}

$error = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username_input = $_POST['username'] ?? '';
    $password_input = $_POST['password'] ?? '';

    // ===== NGO Users Login =====
    $stmt = $conn->prepare(
        "SELECT id, fullname, password FROM ngo_users WHERE fullname = ?"
    );
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
            $error = "Invalid username or password";
        }
    }
    $stmt->close();

    // ===== Rural Users Login =====
    if ($error === "") {
        $stmt = $conn->prepare(
            "SELECT id, FullName, password FROM rural_users WHERE FullName = ?"
        );
        $stmt->bind_param("s", $username_input);
        $stmt->execute();
        $stmt->store_result();

        if($stmt->num_rows === 1){
            $stmt->bind_result($Rural_ID, $FullName, $hashedPassword);
            $stmt->fetch();

            if(password_verify($password_input, $hashedPassword)){
                $_SESSION['Rural_ID'] = $Rural_ID;
                $_SESSION['username'] = $FullName;
                $_SESSION['usertype'] = 'rural';
                $stmt->close();
                $conn->close();
                header("Location: 15_Rural_dashboard.php");
                exit;
            } else {
                $error = "Invalid username or password";
            }
        } else {
            $error = "Username not found";
        }
        $stmt->close();
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Status</title>
</head>

<body style="
    margin:0;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:#f2f6fc;
    font-family:Arial, sans-serif;
">

<?php if ($error !== ""): ?>

    <div style="
        transform: scale(2.5);
        transform-origin: center;
        width: 400px;
        background:#ffffff;
        padding:40px;
        text-align:center;
        border-radius:12px;
        box-shadow:0 4px 15px rgba(0,0,0,0.1);
    ">
        <h1 style="color:#b02a37; margin-bottom:15px;">
            Login Failed
        </h1>

        <p style="color:#333; font-size:16px;">
            <?php echo htmlspecialchars($error); ?>
        </p>

        <a href="Login.html" style="text-decoration:none;">
            <button type="button" style="
                margin-top:25px;
                padding:12px 30px;
                border:none;
                border-radius:8px;
                background:#007bff;
                color:white;
                font-size:16px;
                cursor:pointer;
            ">
                Try Again
            </button>
        </a>
    </div>

<?php endif; ?>

</body>
</html>
