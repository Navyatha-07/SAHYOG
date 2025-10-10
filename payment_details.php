<?php
session_start();
if(!isset($_POST['method'])) header("Location: select_method.php");
$method = $_POST['method'];
$_SESSION['method'] = $method;
?>
<!DOCTYPE html>
<html>
<head><title>Enter Payment Details</title></head>
<body>
<h2>Enter <?= ucfirst($method) ?> Details</h2>

<form action="payment_success.php" method="POST">
<?php if($method == 'credit' || $method == 'debit'): ?>
    <label>Card Number:</label><br>
    <input type="text" name="card" maxlength="16" required><br>
    <label>Expiry:</label><br>
    <input type="text" name="expiry" placeholder="MM/YYYY" required><br>
    <label>CVV:</label><br>
    <input type="password" name="cvv" maxlength="3" required><br><br>
<?php else: ?>
    <label>UPI ID:</label><br>
    <input type="text" name="upi" placeholder="example@upi" required><br><br>
<?php endif; ?>

    <label>Enter OTP:</label><br>
    <input type="password" name="otp" maxlength="6" required><br><br>
    <button type="submit">Verify & Pay</button>
    <input type="hidden" name="confirm" value="yes">
</form>
</body>
</html>
