ALTER TABLE users ADD COLUMN points INT DEFAULT 0;

<?php
session_start();

// Database Connection
$conn = new mysqli("localhost", "root", "", "glh_database");

if (empty($_SESSION['cart'])) {
    header("Location: order.php");
    exit;
}

// 1. Calculate the Total and Points
// We need the product prices again to calculate the total
$products = [
    "wheat" => 2.50, "apple" => 1.25, "orange" => 1.75, "carrot" => 1.75,
    "corn" => 2.45, "sausages" => 5.00, "steak" => 6.00, "porkchop" => 6.50,
    "ham" => 1.50, "chicken" => 10.00, "bacon" => 3.85
];

$total = 0;
foreach ($_SESSION['cart'] as $id => $qty) {
    if(isset($products[$id])) {
        $total += ($products[$id] * $qty);
    }
}

$points_to_earn = floor($total); // 1 point per £1 spent
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout | Greenfield Local Hub</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body { font-family: Arial; margin: 20px; color: white; background-color: #2d5a27; }
        .checkout-container { background: rgba(0,0,0,0.5); padding: 30px; border-radius: 15px; max-width: 500px; margin: auto; }
        input { margin-bottom: 15px; display: block; width: 90%; padding: 10px; }
        .reward-box { background: #ffcc00; color: black; padding: 10px; border-radius: 5px; margin-bottom: 20px; font-weight: bold; text-align: center; }
    </style>
</head>
<body>

<div class="checkout-container">
    <h2>Finalize Your Order</h2>
    
    <div class="reward-box">
        🌟 You are earning <?php echo $points_to_earn; ?> Loyalty Points with this order!
    </div>

    <p><strong>Order Total: £<?php echo number_format($total, 2); ?></strong></p>

    <form method="post" action="process_payment.php">
        <label>Full Name:</label>
        <input type="text" name="name" required>

        <label>Card Number (12 Digits):</label>
        <input type="text" name="card" pattern="\d{12}" maxlength="12" placeholder="123456789012" required>

        <div style="display: flex; gap: 10px;">
            <div style="flex: 1;">
                <label>Expiry (MM/YY):</label>
                <input type="text" name="expiry" pattern="(0[1-9]|1[0-2])\/\d{2}" placeholder="MM/YY" required>
            </div>
            <div style="flex: 1;">
                <label>CVV:</label>
                <input type="text" name="cvv" pattern="\d{3}" maxlength="3" placeholder="123" required>
            </div>
        </div>

        <button type="submit" class="btn" style="width: 100%; padding: 15px; font-size: 18px;">
            Pay £<?php echo number_format($total, 2); ?>
        </button>
    </form>
    
    <br>
    <a href="cart.php" style="color: white;">Back to Cart</a>
</div>

</body>
</html>


needd to be called process_payment.php
<?php
session_start();

// 1. Database Connection
$conn = new mysqli("localhost", "root", "", "glh_database");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 2. Check if the user is logged in and the cart isn't empty
if (!isset($_SESSION['username']) || empty($_SESSION['cart'])) {
    header("Location: login.php");
    exit();
}

// 3. Define prices again to calculate the final points
$products = [
    "wheat" => 2.50, "apple" => 1.25, "orange" => 1.75, "carrot" => 1.75,
    "corn" => 2.45, "sausages" => 5.00, "steak" => 6.00, "porkchop" => 6.50,
    "ham" => 1.50, "chicken" => 10.00, "bacon" => 3.85
];

$total = 0;
foreach ($_SESSION['cart'] as $item => $qty) {
    if (isset($products[$item])) {
        $total += ($products[$item] * $qty);
    }
}

// 4. Calculate points (1 point per £1)
$points_earned = floor($total);
$user = $_SESSION['username'];

// 5. Update the Database
$sql = "UPDATE users SET points = points + ? WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $points_earned, $user);

if ($stmt->execute()) {
    // 6. Success! Clear the cart so they don't buy the same things twice
    unset($_SESSION['cart']);
    
    // Show a success message using your site's style
    echo "<!DOCTYPE html><html><head><link rel='stylesheet' href='styles.css'></head><body>";
    echo "<div class='box' style='text-align:center; margin-top:50px;'>";
    echo "<h1>Payment Successful!</h1>";
    echo "<p>Thank you for supporting Greenfield Local Hub.</p>";
    echo "<p style='color:yellow;'>You earned <strong>$points_earned</strong> loyalty points!</p>";
    echo "<br><a href='index.php' class='btn'>Return to Home</a>";
    echo "</div></body></html>";
} else {
    echo "Error updating rewards: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
