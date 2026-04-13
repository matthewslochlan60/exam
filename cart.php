The order isnt transfering over to cart
here is order code i want the drop down menu where the wheat and sausages are, when you click on them it should ask if you want to add it to cart and if yes add it to cart
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
<div class="order-item">
    <p>Wheat - £2.50</p>
    <img src="images/Wheat.jpg" alt="Wheat" width="80">
    <a href="cart.php?add=Wheat" class="btn">Add to Cart</a>
</div>
<div class="order-item">
    <p>Wheat - £2.50</p>
    <img src="images/Wheat.jpg" alt="Wheat" width="80">
    <a href="cart.php?add=Wheat" class="btn">Add to Cart</a>
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
here is cart code
<?php
session_start();

$products = [
    "wheat" => 2.50,
    "sausages" => 5.00
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

</body>
</html>
and just in case here is checkout code
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


also i want more info and to make the about page look better here is the code for it
<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<title>Greenfield Local Hub| About</title>
<link rel="stylesheet" href="styles.css">
</head>
<body>

<nav>
    <div class="nav-container">
        <div class="logo">
	        <img src="images/logo.jpg" alt="Greenfield Local Hub Logo">
    <ul>
        <li style="font-size:30px; font-weight: bold;"><a href="index.php">Home</a></li>
        <li style="font-size:30px; font-weight: bold;"><a href="about.php" class = "active">About</a></li>
        <li style="font-size:30px; font-weight: bold;"><a href="login.php">Login</a></li>
        <li style="font-size:30px; font-weight: bold;"><a href="dashboard.php">Dashboard</a></li>
        <li style="font-size:30px; font-weight: bold;"><a href="order.php">Order</a></li>
        <li style="font-size:30px; font-weight: bold;"><a href="contact.php">Contact</a></li>
        <li class="dropdown" style="font-size:30px">
            <a href="#">
            </a>
	    </div>
        </li>
    </ul>
    </div>
</nav>
<br>
<div class="dropdown"><img src="images/harrod.jpg" alt="Farm">
  <div class="dropdown-content"><p><strong>Harrop's Farm Shop<br>
Harrop's Farm is a traditional local retailer in Greenfield that focuses on providing high-quality butchery and essential grocery items with a strong emphasis on food safety and hygiene.
Butchery & Deli: Specializes in locally sourced meats and a variety of traditional pies and baked goods.
Local Convenience: Acts as a community hub for fresh produce, dairy, and pantry staples for Greenfield residents.
Quality Standards: Maintains a very high food hygiene rating, ensuring a professional and safe shopping environment.
</strong></p></div>
</div>
<div class="dropdown"><img src="images/Cfarms.jpg" alt="Farm">
  <div class="dropdown-content"><p><strong>Cockfield's Farm Park is an interactive family attraction designed for a full day of adventure, offering a mix of animal encounters and extensive play areas. It is particularly well-regarded for its seasonal holiday events and hands-on activities.
Animal Interactions: Provides handling sessions every 30 minutes with animals ranging from bunnies and guinea pigs to reptiles like lizards and snakes.
Active Play: Features a "Famous Jumping Pillow," fairground carousel, tractor rides, and an indoor role-play village for creative play.
Seasonal Events: Famous for its "Magical Christmas Experience," pumpkin picking in October, and "Lambing Live" in the spring.
Facilities: A cashless venue with a large cafe, picnic areas, and accessible facilities for families with young children.
</strong></p></div>
</div>
<div class="dropdown"><img src="images/local1.jpg" alt="Farm">
  <div class="dropdown-content"><p><strong>Over 30 years, Greenfield Farm Shop has been the heart of Hampshire’s freshest, finest produce—starting with sausages so good, they’ve been crowned "Champion of Champions" across the UK and Ireland.

Tucked along Foundry Road in Hampshire (SP11 7LX), this family-run farm shop is more than a destination—it’s a celebration of tradition, quality, and community. Here, free-range pork, award-winning sausages, and seasonal local goods aren’t just products; they’re a testament to decades of care. Walk in, and you’ll taste the difference: shelves stocked with the best of Hampshire’s harvest, served by friendly faces who know your name.

The story begins with soil and stewardship. Greenfield’s founders built their reputation on passion—raising animals ethically, sourcing nearby, and crafting flavours that stand out in every bite. Today, their farm shop reflects that same commitment: a curated selection of fresh, local produce, from crisp vegetables to artisan pantry staples. Visitors return not just for the food, but for the experience—a warm, unpretentious space where quality speaks for itself.

Open Monday to Friday (9am–5pm) and Saturdays (9am–3pm), Greenfield invites you to slow down, savour, and shop with purpose. Whether you’re stocking up for the week or seeking the secret behind their legendary sausages, you’ll leave with more than a bag—you’ll take home a taste of Hampshire’s finest.

Come hungry. Leave inspired. ""Greenfield Farm Shop—where every visit feels like coming home.""</strong></p></div>
</div>

</body>
</html>
