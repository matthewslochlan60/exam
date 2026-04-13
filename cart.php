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

this isnt working
<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Greenfield Local Hub | Order</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<nav>
 <div class="nav-container">
        <div class="logo">
	<img src="images/logo.jpg" alt="Greenfield Local Hub Logo">
    <ul>
        <li style="font-size:30px; font-weight: bold;"><a href="index.php">Home</a></li>
        <li style="font-size:30px; font-weight: bold;"><a href="about.php">About</a></li>
        <li style="font-size:30px; font-weight: bold;"><a href="login.php">Login</a></li>
        <li style="font-size:30px; font-weight: bold;"><a href="dashboard.php">Dashboard</a></li>
        <li style="font-size:30px; font-weight: bold;"><a href="order.php" class="active">Order</a></li>
        <li style="font-size:30px; font-weight: bold;"><a href="cart.php">Cart</a></li>
        <li style="font-size:30px; font-weight: bold;"><a href="contact.php">Contact</a></li>
        <li class="dropdown" style="font-size:30px">
            <a href="#">
                <?php echo isset($_SESSION['username']) ? "Hello, " . $_SESSION['username'] : "Account"; ?>
            </a>
	</div>
        </li>
    </ul>
</div>
</nav>

<h2>Select Items for Collection</h2>

<div class="dropdown">
  <button class="dropbtn">Grains & Pantry</button>
  <div class="dropdown-content">
    <div class="order-item" onclick="confirmAdd('Wheat', 2.50)">
        <p>Wheat - £2.50</p>
        <img src="images/Wheat.jpg" alt="Wheat" width="80">
    </div>
    </div>
</div>

<div class="dropdown">
  <button class="dropbtn">Meat & Deli</button>
  <div class="dropdown-content">
    <div class="order-item" onclick="confirmAdd('Award-winning Sausages', 5.00)">
        <p>Sausages - £5.00</p>
        <img src="images/sausage.jpg" alt="Sausages" width="80">
    </div>
  </div>
</div>
<?php
// Logic to handle adding items
if (isset($_GET['add'])) {
    $productToAdd = $_GET['add'];
    if (array_key_exists($productToAdd, $products)) {
        if (isset($_SESSION['cart'][$productToAdd])) {
            $_SESSION['cart'][$productToAdd]++;
        } else {
            $_SESSION['cart'][$productToAdd] = 1;
        }
    }
    // Redirect to same page to clear the GET parameter
    header("Location: cart.php");
    exit();
}
?>

<script>
function confirmAdd(itemName, price) {
    let check = confirm("Would you like to add " + itemName + " (£" + price.toFixed(2) + ") to your cart?");
    if (check) {
        alert(itemName + " has been added to your order history!");
        window.location.href = "cart.php?add=" + itemName;
    }
}

</script>

<style>
/* Local style for the order items inside dropdowns */
.order-item {
    padding: 10px;
    border-bottom: 1px solid #ccc;
    background: white;
    cursor: pointer;
    color: black;
}
.order-item:hover { background: #e0ffdf; }
</style>
<!-- need the items ordered to be sent to cart.php-->
</body>
</html>
its not putting it into cart here

<?php
session_start();

$products = [
    "Wheat" => 2.50,
    "Sausages" => 5.00,
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
<a href="order.php">Back to Products</a>
<!-- need cart to show the items that were added in previous page-->
</body>
</html>
