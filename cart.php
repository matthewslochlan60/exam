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

// Remove
if (isset($_GET['remove'])) {
    unset($_SESSION['cart'][$_GET['remove']]);
}

// Update
if (isset($_POST['update'])) {
    foreach ($_POST['qty'] as $product => $qty) {
        if ($qty <= 0) {
            unset($_SESSION['cart'][$product]);
        } else {
            $_SESSION['cart'][$product] = $qty;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cart</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        table { border-collapse: collapse; }
        td, th { padding: 8px; border: 1px solid #ccc; }
        button { margin-top: 10px; }
    </style>
</head>
<body>

<h2>Your Cart</h2>

<?php if (empty($_SESSION['cart'])): ?>
    <p>Your cart is empty.</p>
<?php else: ?>

<form method="post">
<table>
<tr>
    <th>Product</th>
    <th>Price</th>
    <th>Qty</th>
    <th>Total</th>
    <th></th>
</tr>

<?php
$total = 0;
foreach ($_SESSION['cart'] as $product => $qty):
    $price = $products[$product];
    $sub = $price * $qty;
    $total += $sub;
?>

<tr>
    <td><?php echo $product; ?></td>
    <td>£<?php echo $price; ?></td>
    <td>
        <input type="number" name="qty[<?php echo $product; ?>]" value="<?php echo $qty; ?>" style="width:50px;">
    </td>
    <td>£<?php echo $sub; ?></td>
    <td><a href="?remove=<?php echo $product; ?>">Remove</a></td>
</tr>

<?php endforeach; ?>

<tr>
    <td colspan="3"><strong>Total</strong></td>
    <td colspan="2">£<?php echo $total; ?></td>
</tr>

</table>

<button name="update">Update Cart</button>
</form>

<br>
<a href="checkout.php">Proceed to Checkout</a>

<?php endif; ?>

<br><br>
<a href="products.php">Back to Products</a>

</body>
</html>