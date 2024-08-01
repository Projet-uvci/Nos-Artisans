<?php
require '../../../App/Config/database.php';
session_start();


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


try {
    $reqCommune = $connexion->prepare("SELECT id_commune, nom_commune FROM communes");
    $reqCommune->execute();
    $communes = $reqCommune->fetchAll(PDO::FETCH_ASSOC);

    $reqMetier = $connexion->prepare("SELECT id_metier, nom_metier FROM metiers");
    $reqMetier->execute();
    $metiers = $reqMetier->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors de la récupération des informations: " . $e->getMessage());
}


if (isset($_POST['valider'])) {

    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $email = htmlspecialchars($_POST['email']);
    $sexe = htmlspecialchars($_POST['sexe']);
    $contact = htmlspecialchars($_POST['contact']);
    $pays = htmlspecialchars($_POST['pays']);
    $ville = htmlspecialchars($_POST['ville']);
    $metierId = intval($_POST['metier']);
    $communeId = intval($_POST['commune']);
    $latitude = htmlspecialchars($_POST['latitude']);
    $longitude = htmlspecialchars($_POST['longitude']);
    $gpsData = $latitude . ', ' . $longitude;
    $experience = intval($_POST['experience']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    if (strlen($_POST['password']) < 7) {
        $message = "Votre mot de passe est trop court.";
    } elseif (strlen($nom) > 50 || strlen($prenom) > 50) {
        $message = "Votre nom ou prénom est trop long.";
    } elseif ($_POST['password'] == $pseudo) {
        $message = "Le mot de passe ne doit pas être identique au pseudo.";
    } elseif (!in_array($sexe, ['M', 'F'])) {
        $message = "Valeur de sexe invalide.";
    } else {
        $testcontact = $connexion->prepare("SELECT * FROM users WHERE contact = ? OR pseudo = ?");
        $testcontact->execute([$contact, $pseudo]);
        $controlcontactAndpseudo = $testcontact->rowCount();

        if ($controlcontactAndpseudo == 0) {
            $insertion = $connexion->prepare("INSERT INTO users (nom, prenom, pseudo, sexe, email, contact, pays, ville, commune_id, anne_experience, gpsdata, password, metier_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $result = $insertion->execute([$nom, $prenom, $pseudo, $sexe, $email, $contact, $pays, $ville, $communeId, $experience, $gpsData, $password, $metierId]);
            if ($result) {
                echo "<script>
                    alert('Utilisateur : " . $nom . " " . $prenom . " a été enregistré avec succès.');
                    window.location.href = '../login/login.php';
                </script>";
            } else {
                $message = "Erreur lors de l'enregistrement.";
            }
        } else {
            $message = "Le contact ou le pseudo existe déjà.";
        }
    }
}
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/x-icon" href="/Public/images/log75.jpeg">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Inscription</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="script.js"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<style>
    /* Styles CSS pour la mise en page */
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
        display: flex;
        justify-content: center;
        align-items: center;
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
    .text-muted {
        color: #6c757d;
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
    .input-group input, .input-group select {
        width: 100%;
        border: none;
        outline: none;
        padding: 5px;
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
    .mt-3 {
        margin-top: 1rem;
    }
    .name-field {
        display: flex;
        width: 100%;
        justify-content: space-between;
    }
    .name-field div {
        display: flex;
        flex-direction: column;
        width: 43%;
    }

    /* Media Queries pour la réactivité */
    @media (max-width: 768px) {
        .container {
            max-width: 100%;
            margin: 20px;
        }
        .name-field {
            flex-direction: column;
        }
        .name-field div {
            width: 100%;
            margin-bottom: 10px;
        }
    }
    @media (max-width: 480px) {
        .input-group {
            flex-direction: column;
            align-items: flex-start;
        }
        .input-group label {
            margin-bottom: 5px;
        }
    }
</style>
<body class="bg-light">
<div class="container" style="background: #c1f8cb">
    <div class="form-wrapper">
        <h1 class="text-center"><strong>Inscription</strong></h1>
        <form id="registrationForm" method="POST" action="">
            <div class="name-field">
                <div class="input-group">
                    <label for="nom"><i class="fa fa-user"></i></label>
                    <input type="text" id="nom" name="nom" placeholder="Nom" required>
                    <span class="error-message" id="nomError"></span>
                </div>
                <div class="input-group">
                    <label for="prenom"><i class="fa fa-user"></i></label>
                    <input type="text" id="prenom" name="prenom" placeholder="Prénom" required>
                    <span class="error-message" id="prenomError"></span>
                </div>
            </div>
            <div class="name-field">
                <div class="input-group">
                    <label for="email"><i class="fa fa-envelope"></i></label>
                    <input type="email" id="email" name="email" placeholder="Email" required>
                    <span class="error-message" id="emailError"></span>
                </div>
                <div class="input-group">
                    <label for="contact"><i class="fa fa-phone"></i></label>
                    <input type="text" id="contact" name="contact" placeholder="Contact" required>
                    <span class="error-message" id="contactError"></span>
                </div>
            </div>
            <div class="input-group">
                <label for="pays"><i class="fa fa-globe"></i></label>
                <select id="pays" name="pays" required>
                    <option value="ci">Côte d'Ivoire</option>
                    <option value="ca">Cameroun</option>
                    <option value="gh">Ghana</option>
                    <option value="bf">Burkina Faso</option>
                    <option value="mi">Mali</option>
                    <option value="se">Senegal</option>
                </select>
                <span class="error-message" id="paysError"></span>
            </div>
            <div class="input-group">
                <label for="sexe"><i class="fa fa-venus-mars"></i> Sexe</label><br>
                <input type="radio" id="homme" name="sexe" value="M" required>
                <label for="homme">Homme</label>
                <input type="radio" id="femme" name="sexe" value="F" required>
                <label for="femme">Femme</label>
            </div>
            <div class="name-field">
                <div class="input-group">
                    <label for="ville"><i class="fas fa-city"></i></label>
                    <input type="text" id="ville" name="ville" placeholder="Ville" required>
                    <span class="error-message" id="villeError"></span>
                </div>
                <div class="input-group">
                    <label for="commune"><i class="fas fa-city"></i> Commune</label>
                    <select id="commune" name="commune" required>
                        <?php foreach ($communes as $commune): ?>
                            <option value="<?php echo htmlspecialchars($commune['id_commune']); ?>"><?php echo htmlspecialchars($commune['nom_commune']); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <span class="error-message" id="communeError"></span>
                </div>
            </div>
            <div class="name-field">
                <div class="input-group">
                    <label for="metier"><i class="fas fa-briefcase"></i> Métier</label>
                    <select id="metier" name="metier" required>
                        <?php foreach ($metiers as $metier): ?>
                            <option value="<?php echo htmlspecialchars($metier['id_metier']); ?>"><?php echo htmlspecialchars($metier['nom_metier']); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <span class="error-message" id="metierError"></span>
                </div>
                <div class="input-group">
                    <label for="experience"><i class="fas fa-chart-line"></i></label>
                    <input type="number" id="experience" name="experience" placeholder="Années d'expérience" required>
                    <span class="error-message" id="experienceError"></span>
                </div>
            </div>
            <div class="name-field">
                <div class="input-group">
                    <label for="latitude"><i class="fa fa-map-marker-alt"></i></label>
                    <input type="text" id="latitude" name="latitude" placeholder="Latitude (facultatif)">
                    <span class="error-message" id="latitudeError"></span>
                </div>
                <div class="input-group">
                    <label for="longitude"><i class="fa fa-map-marker-alt"></i></label>
                    <input type="text" id="longitude" name="longitude" placeholder="Longitude (facultatif)">
                    <span class="error-message" id="longitudeError"></span>
                </div>
            </div>
            <p class="text-center text-muted mt-3">
                En cliquant sur ce lien vous pouvez obtenir vos <a href="https://www.coordonnees-gps.fr/" target='_blank'>coordonnees-gps</a>
            </p>
            <br/>
            <div class="input-group">
                <label for="pseudo"><i class="fa fa-user"></i></label>
                <input type="text" id="pseudo" name="pseudo" placeholder="pseudo name( ex: Anicet10 )" required>
                <span class="error-message" id="pseudoError"></span>
            </div>
            <div class="input-group">
                <label for="password"><i class="fa fa-lock"></i></label>
                <input type="password" id="password" name="password" placeholder="Mot de passe" required>
                <span class="error-message" id="passwordError"></span>
            </div>
            <div class="input-group">
                <label for="password_repeat"><i class="fa fa-lock"></i></label>
                <input type="password" id="password_repeat" name="password_repeat" placeholder="Confirmez le mot de passe" required>
                <span class="error-message" id="password_repeatError"></span>
            </div>
            <span class="toggle-password" onclick="togglePasswordVisibility()">
        <p>Voir le mot de passe
            <i class="fa fa-eye" id="eye-icon"></i>
        </p>
    </span>

            <div class="d-grid">
                <button class="btn btn-primary btn-block" type="submit" name="valider">S'inscrire</button>
            </div>
            <div class="d-grid">
                <p class="text-center text-muted mt-3">
                    En cliquant sur S’inscrire, vous acceptez nos <a href="#">Conditions générales</a>, notre <a href="#">Politique de confidentialité</a> et notre <a href="#">Politique d’utilisation</a> des cookies.
                </p>
                <p class="text-center">
                    <i style="color: red">
                        <?php
                        if (isset($message)){
                            echo $message.'<br />';
                        }
                        ?>
                    </i>
                    Avez-vous déjà un compte ? <a href="../login/login.php">Connexion</a>
                </p>
            </div>
        </form>

</body>
</html>