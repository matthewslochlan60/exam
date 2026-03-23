<?php
session_start();

if (empty($_SESSION['cart'])) {
    echo "Cart is empty.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        input { margin-bottom: 10px; display: block; }
    </style>
</head>
<body>

<h2>Checkout</h2>

<form method="post" action="process.php">

    Name:
    <input type="text" name="name" required>

    Card Number:
    <input 
        type="text" 
        name="card" 
        pattern="\d{12}" 
        maxlength="12"
        placeholder="12 digits"
        title="Card number must be exactly 12 digits"
        required
    >

    Expiry (MM/YY):
    <input 
        type="text" 
        name="expiry" 
        pattern="(0[1-9]|1[0-2])\/\d{2}" 
        placeholder="MM/YY"
        title="Format must be MM/YY"
        required
    >

    CVV:
    <input 
        type="text" 
        name="cvv" 
        pattern="\d{3}" 
        maxlength="3"
        placeholder="3 digits"
        title="CVV must be 3 digits"
        required
    >

    <button type="submit">Pay</button>

</form>

</body>
</html>