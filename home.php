<?php
session_start();
require "config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Boekenpaal</title>
    <link rel="stylesheet" href= "app.css">
    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSiy-SeNjEmh7kBWw5doWlpaf-P2JTV23JYhQ&s">
</head>
<body>
    <div class="container">
        <div id="home" class="flex-center flex-column">
            <h1>Boekenpaal</h1>
            <a class="btn"  href="game.html">Play</a>
            <a class="btn"  href="shop.html">Shop</a>
            <a class="btn"  href="account.php">Account</a>
            <a class="btn"  href="logout.php">Logout</a>

        </div>
    </div>
<head>
    <img src="https://www.lodewijkcollege.nl/dbupload/_p94_c9b5ee243121a00c3365db0bdc1eaa2e629cddde.jpg">
</head>
    
</body>
</html>