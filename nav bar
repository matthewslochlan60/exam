<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<title>Bean and Brew | Home</title>
<style>
    /* Your existing styles + dropdown additions */
    .dropdown { position: relative; display: inline-block; }
    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #000000;
        min-width: 160px;
        box-shadow: 0px 8px 16px rgba(0,0,0,0.2);
        z-index: 1;
        padding: 10px;
        border-radius: 10px;
    }
    .dropdown:hover .dropdown-content { display: block; }
    
    .form-input { margin-bottom: 10px; width: 90%; }
    .btn { background-color: #b32d00; color: white; border: none; padding: 5px 10px; cursor: pointer; }
</style>
</head>
<body>

<nav>
    <ul>
        <li style="font-size:30px"><a href="index.php" class="active">Home</a></li>
        <li class="dropdown" style="font-size:30px">
            <a href="#">
                <?php echo isset($_SESSION['username']) ? "Hello, " . $_SESSION['username'] : "Account"; ?>
            </a>
            <div class="dropdown-content">
                <?php if(isset($_SESSION['username'])): ?>
                    <a href="logout.php">Logout</a>
                <?php else: ?>
                    <form action="auth.php" method="POST">
                        <input type="text" name="user" placeholder="Username" class="form-input" required><br>
                        <input type="password" name="pass" placeholder="Password" class="form-input" required><br>
                        <button type="submit" name="login" class="btn">Login</button>
                        <button type="submit" name="register" class="btn">Register</button>
                    </form>
                <?php endif; ?>
            </div>
        </li>
    </ul>
</nav>

<div class="box">
    <center>
        <h1>Welcome to Bean and Brew</h1>
        <p><?php echo isset($_SESSION['username']) ? "Glad to have you back!" : "Login to start your coffee journey."; ?></p>
    </center>
</div>

</body>
</html>
