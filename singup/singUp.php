<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="../login/style.css">
    <script src="script.js" defer></script>
</head>
<body>
<div class="form-container">
    <form action="singUp.php" method="post">
        <h1>Inscription</h1>
        <input type="text" name="nom" placeholder="Nom" required>
        <input type="text" name="prenom" placeholder="Prenom" required>
        <input type="text" name="adresse" placeholder="Adresse" required>
        <input type="text" name="contact" placeholder="Contact" required>
        <select name="pays" required>
            <option value="ci">Côte d'Ivoire</option>
            <option value="ca">Cameroun</option>
            <option value="gh">Ghana</option>
            <option value="bf">Burkina Faso</option>
            <option value="mi">Mali</option>
            <option value="se">Senegal</option>
        </select>
        <input type="text" name="ville" placeholder="Ville" required>
        <input type="text" name="metier" placeholder="metier" required>
        <input type="text" id="latitude" name="latitude" placeholder="Latitude" required>
        <input type="text" id="longitude" name="longitude" placeholder="Longitude" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <button type="submit">Inscription</button>
    </form>
    <p>Déjà un compte? <a href="../login/login.php">Connexion</a></p>
</div>
</body>
</html>
<!--// refaire si possible-->