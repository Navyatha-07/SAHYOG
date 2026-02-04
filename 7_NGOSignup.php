<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sahyog1";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = false;
$errorMsg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!isset($_POST['email'])) {
        die("Email field not sent — form is broken.");
    }

    $fullname      = $_POST['fullname'];
    $email         = $_POST['email'];
    $pass          = $_POST['password'];
    $mobile_number = $_POST['mobile_number'];
    $nameofNGO     = $_POST['nameofNGO'];
    $location      = $_POST['location'];

    $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);

    $check = $conn->prepare(
        "SELECT id FROM ngo_users WHERE mobile_number = ? OR email = ?"
    );
    $check->bind_param("ss", $mobile_number, $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $errorMsg = "Mobile number or email already exists.";
    } else {

        $stmt = $conn->prepare(
            "INSERT INTO ngo_users 
            (fullname, email, password, mobile_number, nameofNGO, location)
            VALUES (?, ?, ?, ?, ?, ?)"
        );

        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param(
            "ssssss",
            $fullname,
            $email,
            $hashedPassword,
            $mobile_number,
            $nameofNGO,
            $location
        );

        if ($stmt->execute()) {
            $result = true;
        } else {
            $errorMsg = $stmt->error;
        }

        $stmt->close();
    }

    $check->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Signup Status</title>
</head>

<body style="
    margin:0;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:#f2f6fc;
    font-family:Arial, sans-serif;
" >

<?php if ($result): ?>

    <div style="
        transform-origin: center;
        width: 400px;
        background:#ffffff;
        padding:40px;
        text-align:center;
        border-radius:12px;
        box-shadow:0 4px 15px rgba(0,0,0,0.1);
    ">
        <h1 style="color:#1e7e34; margin-bottom:25px;">
            Signup Successful!
        </h1>

        <a href="6_Login.php" style="text-decoration:none;">
            <button type="button" style="
                padding:12px 30px;
                border:none;
                border-radius:8px;
                background:#007bff;
                color:white;
                font-size:16px;
                cursor:pointer;
            ">
                Go to Login
            </button>
        </a>
    </div>

<?php else: ?>

    <div style="
        width:50%;
        background:#ffffff;
        padding:40px;
        text-align:center;
        border-radius:12px;
        box-shadow:0 4px 15px rgba(0,0,0,0.1);
    ">
        <h1 style="color:#b02a37;">Signup Failed</h1>

        <p style="margin-top:15px; color:#333;">
            <?php echo htmlspecialchars($errorMsg); ?>
        </p>
    </div>

<?php endif; ?>

</body>
</html>
