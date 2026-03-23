<?php
session_start();

$products = [
    "Laptop" => 800,
    "Headphones" => 100,
    "Phone" => 500
];

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$message = "";

if (isset($_POST['product'])) {
    $product = $_POST['product'];
    $qty = (int)$_POST['qty'];

    if ($qty > 0) {
        if (isset($_SESSION['cart'][$product])) {
            $_SESSION['cart'][$product] += $qty;
        } else {
            $_SESSION['cart'][$product] = $qty;
        }
        $message = "Added $qty x $product to cart.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Products</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        .product { border: 1px solid #ccc; padding: 10px; margin-bottom: 10px; width: 250px; }
        button { margin-top: 5px; }
    </style>
</head>
<body>

<h2>Products</h2>

<?php if ($message): ?>
    <p style="color: green;"><?php echo $message; ?></p>
<?php endif; ?>

<?php foreach ($products as $name => $price): ?>
    <div class="product">
        <strong><?php echo $name; ?></strong><br>
        Price: £<?php echo $price; ?><br><br>

        <form method="post">
            Qty:
            <input type="number" name="qty" value="1" min="1" style="width:50px;">
            <input type="hidden" name="product" value="<?php echo $name; ?>">
            <br>
            <button type="submit">Add to Cart</button>
        </form>
    </div>
<?php endforeach; ?>

<br>
<a href="cart.php">Go to Cart</a>

</body>
</html>