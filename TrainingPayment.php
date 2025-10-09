<?php
session_start();
if (!isset($_SESSION['Rural_ID']) || !isset($_SESSION['Pending_Training_ID'])) {
    header("Location: 15_Rural_dashboard.html");
    exit;
}

$rural_id = $_SESSION['Rural_ID'];
$training_id = $_SESSION['Pending_Training_ID'];

$amount = 50; // dummy amount
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Training Payment</title>
<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f5f5f5;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}
.container {
    background-color: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    width: 400px;
}
h2 { text-align: center; margin-bottom: 20px; }
input, select { width: 100%; padding: 10px; margin: 10px 0; border-radius: 5px; border: 1px solid #ccc; }
button {
    background-color: #4CAF50; color: white; border: none;
    padding: 12px; border-radius: 6px; width: 100%; font-size: 16px; cursor: pointer;
}
button:hover { background-color: #45a049; }
.amount-box { background: #f0f0f0; padding: 10px; border-radius: 6px; margin-bottom: 20px; font-weight: bold; text-align: center; }
</style>
</head>
<body>
<div class="container">
    <h2>Training Payment</h2>
    <div class="amount-box">Total Amount: ₹<?php echo $amount; ?></div>

    <form method="POST" action="ProcessPayment.php">
        <label>Cardholder Name</label>
        <input type="text" name="card_name" placeholder="John Doe" required>

        <label>Card Number</label>
        <input type="text" name="card_number" placeholder="1234 5678 9012 3456" maxlength="16" required>

        <label>Expiry Month</label>
        <select name="expiry_month" required>
            <?php for($m=1;$m<=12;$m++) echo "<option>$m</option>"; ?>
        </select>

        <label>Expiry Year</label>
        <select name="expiry_year" required>
            <?php $year = date("Y"); for($y=$year;$y<$year+10;$y++) echo "<option>$y</option>"; ?>
        </select>

        <label>CVV</label>
        <input type="text" name="cvv" placeholder="123" maxlength="3" required>

        <p style="text-align:center;">or</p>

        <label>UPI ID / QR Code </label>
        <input type="text" name="upi" placeholder="example@upi">

        <button type="submit" name="pay">Pay Now</button>
    </form>
</div>
</body>
</html>
