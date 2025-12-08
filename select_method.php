<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head><title>Select Payment Method</title></head>
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
<form  method="POST" action="payment_details.php"
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
color: #222;
padding: 15px 15px;"
>
Select Payment Method</h2>
    <label style="
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 15px;
    background: #f7f9ff;
    border: 1px solid #d8e0f0;
    border-radius: 8px;
    cursor: pointer;"
    >
        <input type="radio" name="method" value="credit" required
        style="
        width: 18px;
        height: 18px;
        cursor: pointer;">
         Credit Card
    </label><br>
    <label  style="
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 15px;
    background: #f7f9ff;
    border: 1px solid #d8e0f0;
    border-radius: 8px;
    cursor: pointer;">
        <input type="radio" name="method" value="debit"
         style="
        width: 18px;
        height: 18px;
        cursor: pointer;"> 
        Debit Card
    </label><br>
    <label  style="
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 15px;
    background: #f7f9ff;
    border: 1px solid #d8e0f0;
    border-radius: 8px;
    cursor: pointer;">
        <input type="radio" name="method" value="upi"
         style="
        width: 18px;
        height: 18px;
        cursor: pointer;">
         UPI
    </label><br><br>
    <button type="submit"
    style="
display: block;
padding: 15px 15px;
font-size: 18px;
font-weight: bold;
text-decoration: none;
text-align: center;
background: #3563f9;
color: white;
border-radius: 8px;
transition: 0.15s ease">
Proceed → Enter Details</button>
</form>
</body>
</html>

