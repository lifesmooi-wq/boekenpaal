<?php
session_start();
$stmt = $conn->prepare("SELECT points FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION["user_id"]);
$stmt->execute();
$stmt->bind_result($points);
$stmt->fetch();
$stmt->close();
?>

<h2>Your points: <?php echo $points; ?> ⭐</h2>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Quick Quiz - Play</title>
    <link rel="stylesheet" href= "app.css">
</head>
<body>
    <div class="container">
        <div id="home" class="flex-center flex-column">
            <h1>Hier zie je de account informatie:3</h1>
        </div>
    </div>
    
</body>
</html>