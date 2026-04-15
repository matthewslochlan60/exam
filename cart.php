<?php
session_start();

$products = [
    "wheat" => 2.50,
    "sausages" => 5.00
];

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// ADD ITEM
if (isset($_GET['add'])) {
    $productToAdd = strtolower($_GET['add']);
    if (array_key_exists($productToAdd, $products)) {
        if (isset($_SESSION['cart'][$productToAdd])) {
            $_SESSION['cart'][$productToAdd]++;
        } else {
            $_SESSION['cart'][$productToAdd] = 1;
        }
    }
    header("Location: cart.php");
    exit();
}

// REMOVE ITEM
if (isset($_GET['remove'])) {
    unset($_SESSION['cart'][$_GET['remove']]);
    header("Location: cart.php");
    exit();
}

// ✅ UPDATE CART (THIS WAS MISSING)
if (isset($_POST['update'])) {
    foreach ($_POST['qty'] as $product => $quantity) {
        $quantity = (int)$quantity;

        if ($quantity <= 0) {
            unset($_SESSION['cart'][$product]);
        } else {
            $_SESSION['cart'][$product] = $quantity;
        }
    }

    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Greenfield Local Hub | Order</title>
    <link rel="stylesheet" href="styles.css">
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
    <td><?php echo htmlspecialchars($product); ?></td>
    <td>£<?php echo number_format($price, 2); ?></td>
    <td>
        <input type="number" 
               name="qty[<?php echo $product; ?>]" 
               value="<?php echo $qty; ?>" 
               min="0"
               style="width:50px;">
    </td>
    <td>£<?php echo number_format($sub, 2); ?></td>
    <td>
        <a href="?remove=<?php echo urlencode($product); ?>">Remove</a>
    </td>
</tr>

<?php endforeach; ?>

<tr>
    <td colspan="3"><strong>Total</strong></td>
    <td colspan="2">£<?php echo number_format($total, 2); ?></td>
</tr>

</table>

<button type="submit" name="update">Update Cart</button>
</form>

<br>
<a href="checkout.php">Proceed to Checkout</a>

<?php endif; ?>

<br><br>
<a href="order.php">Back to Products</a>

</body>
</html>
