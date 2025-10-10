<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head><title>Select Payment Method</title></head>
<body>
<h2>Select Payment Method</h2>
<form method="POST" action="payment_details.php">
    <label><input type="radio" name="method" value="credit" required> Credit Card</label><br>
    <label><input type="radio" name="method" value="debit"> Debit Card</label><br>
    <label><input type="radio" name="method" value="upi"> UPI</label><br><br>
    <button type="submit">Proceed → Enter Details</button>
</form>
</body>
</html>

