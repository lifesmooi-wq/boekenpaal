<?php
session_start();
require "config.php";

$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // =========================
    // REGISTER
    // =========================
    if ($_POST['form_type'] === 'register') {

        $name = $_POST['username']; // your form input
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $role = $_POST['role'];
        $nfc_id = NULL; // optional for now

        $sql = "INSERT INTO users (name, email, password, nfc_id, role, points) VALUES (?, ?, ?, ?, ?, 0)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $name, $email, $password, $nfc_id, $role);

        if ($stmt->execute()) {
            $_SESSION['user_id'] = $stmt->insert_id;
            $_SESSION['username'] = $name;

            header("Location: home.php");
            exit;
        } else {
            $error = "Registration error: " . $stmt->error;
        }
    }

    // =========================
    // LOGIN
    // =========================
    elseif ($_POST['form_type'] === 'login') {

        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($user = $result->fetch_assoc()) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['name']; // updated to 'name'
                $_SESSION['points'] = $user['points']; // store points in session

                header("Location: home.php");
                exit;
            } else {
                $error = "Wrong password!";
            }
        } else {
            $error = "User not found!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Boekenpaal Program</title>
<link rel="stylesheet" href="login.css">
</head>
<body>

<div class="container">

    <?php if ($error): ?>
        <p style="color:red; text-align:center;"><?php echo $error; ?></p>
    <?php endif; ?>

    <!-- LOGIN FORM -->
    <div class="form-box active" id="login-form">
        <form action="" method="POST">
            <input type="hidden" name="form_type" value="login">
            <h2>Login</h2>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
            <p>Don't have an account? <a href="#" onclick="showForm('register-form')">Register</a></p>
        </form>
    </div>

    <!-- REGISTER FORM -->
    <div class="form-box" id="register-form">
        <form action="" method="POST">
            <input type="hidden" name="form_type" value="register">
            <h2>Register</h2>
            <input type="text" name="username" placeholder="Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <select name="role" required>
                <option value="">--Select Role--</option>
                <option value="user">User</option>
            </select>
            <button type="submit">Register</button>
            <p>Already have an account? <a href="#" onclick="showForm('login-form')">Login</a></p>
        </form>
    </div>

</div>

<script src="login.js"></script>
</body>
</html>
