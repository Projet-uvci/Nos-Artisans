<?php
require '../../../App/Config/database.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom_user = $_POST['nom_user'];
    $prenom_user = $_POST['prenom_user'];
    $adresse_user = $_POST['adresse_user'];
    $contact = $_POST['contact'];
    $pays = $_POST['pays'];
    $ville = $_POST['ville'];
    $metier = $_POST['metier'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $gpsData = $latitude . ', ' . $longitude;
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $pdo->prepare('INSERT INTO users (nom_user, prenom_user, adresse_user, contact, pays, ville, metier, gpsData, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
    if ($stmt->execute([$nom_user, $prenom_user, $adresse_user, $contact, $pays, $ville, $metier, $gpsData, $password])) {
        $message = "Registration successful! You will be redirected to the login page in 3 seconds.";
        echo "<script>
                setTimeout(function() {
                    window.location.href = '../login/login.php';
                }, 3000);
              </script>";
    } else {
        $message = "Registration failed!";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="../../../../Nos-Artisans/Vue/Pages/singup/style.css">
</head>
<body>
    <div class="form-container">
        <form action="signup.php" method="post">
            <h1>Inscription</h1>
            <input type="text" name="nom_user" placeholder="Nom" required>
            <input type="text" name="prenom_user" placeholder="Prenom" required>
            <input type="text" name="adresse_user" placeholder="Adresse" required>
            <input type="text" name="contact" placeholder="Contact" required>
            <select name="pays" required>
                <option value="Côte d'Ivoire">Côte d'Ivoire</option>
                <option value="Cameroun">Cameroun</option>
                <option value="Ghana">Ghana</option>
                <option value="Burkina Faso">Burkina Faso</option>
                <option value="Mali">Mali</option>
                <option value="Senegal">Senegal</option>
            </select>
            <input type="text" name="ville" placeholder="Ville" required>
            <input type="text" name="metier" placeholder="Metier" required>
            <input type="text" id="latitude" name="latitude" placeholder="Latitude" required>
            <input type="text" id="longitude" name="longitude" placeholder="Longitude" required>
            <input type="password" name="password" id="password" placeholder="Mot de passe" required>
            <label><input type="checkbox" onclick="togglePassword()"> Show Password</label>
            <button type="submit">Inscription</button>
        </form>
        <p>Déjà un compte? <a href="../login/login.php">Connexion</a></p>
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
