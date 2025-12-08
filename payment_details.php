<?php
session_start();
if(!isset($_POST['method'])) header("Location: select_method.php");
$method = $_POST['method'];
$_SESSION['method'] = $method;
?>
<!DOCTYPE html>
<html>
<head><title>Enter Payment Details</title></head>
<body
style="
margin: 0;
font-family: Arial,sans-serif;
background: #f2f6fb;
display: flex;
justify-content:center;
align-items:center;
height: 100vh;"
>
<form action="payment_success.php" method="POST"
style="
    display:flex ;
    flex-direction: column;
    align-items: center;
    background-color: #ffffff;
    padding: 15px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    width: 350px;
    margin:50px auto;
">
<h2
 style="
margin : 0 0 15px;
font-size: 28px;
font-weight: 700;
color: #222;"
>Enter <?= ucfirst($method) ?> Details</h2>
<?php if($method == 'credit' || $method == 'debit'): ?>
    <label style="
     width: 100%;
     margin-top: 12px;
     font-size: 16px;"
    >Card Number:</label><br>
    <input type="text" name="card" maxlength="16" required
     style="
     width: 100%;
     padding: 12px;
     margin-top: 6px;
     border: 1px solid #d8e0f0;
     font-size: 16px;
     box-sizing: border-box;"
    ><br>
    <label
    style="
     width: 100%;
     margin-top: 12px;
     font-size: 16px;"
     >Expiry:</label><br>
    <input type="text" name="expiry" placeholder="MM/YYYY" required
    style="
     width: 100%;
     padding: 12px;
     margin-top: 6px;
     border: 1px solid #d8e0f0;
     font-size: 16px;
     box-sizing: border-box;"
     ><br>
    <label 
    style="
     width: 100%;
     margin-top: 12px;
     font-size: 16px;"
     >CVV:</label><br>
    <input type="password" name="cvv" maxlength="3" required 
    style="
     width: 100%;
     padding: 12px;
     margin-top: 6px;
     border: 1px solid #d8e0f0;
     font-size: 16px;
     box-sizing: border-box;"><br><br>
<?php else: ?>
    <label style="
     width: 100%;
     margin-top: 12px;
     font-size: 16px;"
     >UPI ID:</label><br>
    <input type="text" name="upi" placeholder="example@upi" required
    style="
     width: 100%;
     padding: 12px;
     margin-top: 6px;
     border: 1px solid #d8e0f0;
     font-size: 16px;
     box-sizing: border-box;"><br><br>
<?php endif; ?>
    <button type="submit"
     style="
display: block;
padding: 15px 45px;
font-size: 18px;
font-weight: bold;
text-decoration: none;
text-align: center;
background: #3563f9;
color: white;
border-radius: 8px;
transition: 0.15s ease">Pay</button>
    <input type="hidden" name="confirm" value="yes">
</form>
</body>
</html>
