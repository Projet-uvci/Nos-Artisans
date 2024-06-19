<?php
require '../../../App/Config/database.php';
session_start();

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contact = $_POST['contact'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare('SELECT * FROM users WHERE contact = ?');
    $stmt->execute([$contact]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $message = 'Login successful! You will be redirected to the Dashboard page in 3 seconds';
        echo "<script>
                setTimeout(function() {
                    window.location.href = '../../../Vue/Pages/Admin/pages/home.php';
                }, 3000);
              </script>";
        exit();
    } else {
        $message = "Invalid username or password!";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="../../../../Nos-Artisans/Vue/Pages/login/style.css">
</head>
<body>
<div class="form-container">
    <form action="login.php" method="post">
        <h1>Connexion</h1>
        <input type="text" name="contact" placeholder="Contact" required>
        <div class="showPassword">
            <input type="password" name="password" id="password" placeholder="Mot de passe" required>
            <input class="checked" type="checkbox" onclick="togglePassword()">
        </div>
        <a href="#">Mot de passe oublié?</a>
        <button type="submit">Connexion</button>
    </form>
    <p>Pas encore de compte? <a href="../singup/singUp.php">Inscription</a></p>
</div>

<?php
    if ($message) {
        echo "<p>$message</p>";
    }
    ?>


<script>
        function togglePassword() {
            var passwordField = document.getElementById("password");
            if (passwordField.type === "password") {
                passwordField.type = "text";
            } else {
                passwordField.type = "password";
            }
        }
    </script>
</body>
</html>

<!--// refaire si possible-->
