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
        input { margin-bottom: 10px; }
    </style>
</head>
<body>

<h2>Checkout</h2>

<form method="post" action="process.php">
    Name:<br>
    <input type="text" name="name" required><br>

    Card Number:<br>
    <input type="text" name="card" required><br>

    Expiry:<br>
    <input type="text" name="expiry" required><br>

    CVV:<br>
    <input type="text" name="cvv" required><br>

    <button type="submit">Pay</button>
</form>

</body>
</html>