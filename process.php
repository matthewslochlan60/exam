<?php
session_start();

// Make sure form was submitted
if (!isset($_POST['name'])) {
    echo "Invalid access.";
    exit;
}

$name = $_POST['name'];

// Clear cart AFTER payment
unset($_SESSION['cart']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Done</title>
</head>
<body>

<h2>Order Complete</h2>

<p>Thanks <?php echo $name; ?>, your order was placed.</p>

<a href="products.php">Go back</a>

</body>
</html>