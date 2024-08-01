<?php
require '../../../App/Config/database.php';
session_start();


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['login'])) {
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $password = htmlspecialchars($_POST['password']);


    $query = $connexion->prepare("SELECT * FROM users WHERE pseudo = ?");
    $query->execute([$pseudo]);
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['id_user'] = $user['id_user'];
        $_SESSION['pseudo'] = $user['pseudo'];


        header('Location: ../../../index.php');
        exit();
    } else {
        $message = "Pseudo ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/x-icon" href="/Public/images/log75.jpeg">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Connexion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<style>
    body {
        background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
        url('/Public/images/artisan-mecanique1.jpeg') no-repeat center center fixed;
        background-size: cover;
        font-family: Arial, sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }
    .container {
        max-width: 400px;
        width: 100%;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .text-center {
        text-align: center;
    }
    .form-wrapper {
        margin: auto;
    }
    .input-group {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
        padding: 10px;
        border: 1px solid #ced4da;
        border-radius: 5px;
    }
    .input-group label {
        margin-right: 10px;
    }
    .input-group input {
        width: 100%;
        border: none;
        outline: none;
    }
    .d-grid {
        display: grid;
        gap: 10px;
    }
    .btn {
        padding: 10px;
        background-color: #28a745;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-align: center;
    }
    .btn:hover {
        background-color: #218838;
    }
    a {
        color: #007bff;
        text-decoration: none;
    }
    a:hover {
        text-decoration: underline;
    }
</style>
<body>
<div class="container">
    <div class="form-wrapper">
        <h2 class="text-center">Connexion</h2>
        <form method="POST" action="">
            <div class="input-group">
                <label for="pseudo"><i class="fa fa-envelope"></i></label>
                <input type="text" id="pseudo" name="pseudo" placeholder=" votre pseudo" required>
            </div>
            <div class="input-group">
                <label for="password"><i class="fa fa-lock"></i></label>
                <input type="password" id="password" name="password" placeholder="Mot de passe" required>
            </div>
            <div class="d-grid">
                <button type="submit" name="login" class="btn btn-success">Se connecter</button>
                <p class="text-center">
                    <i style="color: red">
                        <?php
                        if (isset($message)) {
                            echo $message.'<br />';
                        }
                        ?>
                    </i>
                    Vous n'avez pas de compte ? <a href="../singup/singup.php">Inscription</a>
                    <br>
                    <br>
                Sinon retour a l'accueil <a href="../../../index.php">Retour</a>
                </p>
            </div>
        </form>
    </div>
</div>
</body>
</html>
