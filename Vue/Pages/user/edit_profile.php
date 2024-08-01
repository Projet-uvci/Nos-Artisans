<?php
session_start();

require_once '../../../App/Config/database.php';

if (!isset($connexion)) {
    die("Erreur de connexion à la base de données");
}

if (!isset($_SESSION['id_user'])) {
    die("Vous devez être connecté pour voir cette page.");
}

$id_user = $_SESSION['id_user'];

try {
    $req = $connexion->prepare("
        SELECT u.*, c.nom_commune, m.nom_metier
        FROM users u
        JOIN communes c ON u.commune_id = c.id_commune
        JOIN metiers m ON u.metier_id = m.id_metier
        WHERE u.id_user = :id
    ");
    $req->bindParam(':id', $id_user, PDO::PARAM_INT);
    $req->execute();
    $userData = $req->fetch(PDO::FETCH_ASSOC);

    // Vérifier si l'utilisateur a été trouvé
    if (!$userData) {
        die("Utilisateur non trouvé.");
    }


    $communesQuery = $connexion->query("SELECT id_commune, nom_commune FROM communes");
    $communes = $communesQuery->fetchAll(PDO::FETCH_ASSOC);


    $metiersQuery = $connexion->query("SELECT id_metier, nom_metier FROM metiers");
    $metiers = $metiersQuery->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erreur lors de la récupération des informations utilisateur : " . $e->getMessage());
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $userData['nom'] = $_POST['nom'];
    $userData['prenom'] = $_POST['prenom'];
    $userData['email'] = $_POST['email'];
    $userData['contact'] = $_POST['contact'];
    $userData['pays'] = $_POST['pays'];
    $userData['ville'] = $_POST['ville'];
    $userData['commune_id'] = $_POST['commune'];
    $userData['metier_id'] = $_POST['metier'];
    $userData['anne_experience'] = $_POST['experience'];
    $userData['gpsdata'] = $_POST['gpsData'];
    $userData['sexe'] = $_POST['sexe'];

    try {
        $updateQuery = $connexion->prepare(
            "UPDATE users SET nom = :nom, prenom = :prenom, email= :email, contact = :contact, pays = :pays, ville = :ville, commune_id = :commune, metier_id = :metier, anne_experience = :experience, gpsdata = :gpsData, sexe = :sexe WHERE id_user = :id"
        );

        $updateQuery->bindParam(':nom', $userData['nom']);
        $updateQuery->bindParam(':prenom', $userData['prenom']);
        $updateQuery->bindParam(':email', $userData['email']);
        $updateQuery->bindParam(':contact', $userData['contact']);
        $updateQuery->bindParam(':pays', $userData['pays']);
        $updateQuery->bindParam(':ville', $userData['ville']);
        $updateQuery->bindParam(':commune', $userData['commune_id']);
        $updateQuery->bindParam(':metier', $userData['metier_id']);
        $updateQuery->bindParam(':experience', $userData['anne_experience']);
        $updateQuery->bindParam(':gpsData', $userData['gpsdata']);
        $updateQuery->bindParam(':sexe', $userData['sexe']);
        $updateQuery->bindParam(':id', $id_user, PDO::PARAM_INT);

        $updateQuery->execute();

        header('Location: users.php?success=1');
        exit();
    } catch (PDOException $e) {
        die("Erreur lors de la mise à jour des informations utilisateur : " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="/Public/images/log75.jpeg">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Modifier Profil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
            url('/Public/images/Artisans-femme1.jpeg')no-repeat center center fixed;
            align-items: center;
            background-size: cover;
            color: white;
            margin: 0;
            height: 100vh;
            flex-direction: column;
            justify-content: center;
        }
        .profile-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
        }
        form label {
            display: block;
            margin-top: 10px;
        }
        form input {
            width: calc(100% - 20px);
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .buttons {
            text-align: center;
        }
        .buttons button {
            display: inline-block;
            margin: 10px;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #007BFF;
            color: #fff;
            cursor: pointer;
        }
        .buttons button:hover {
            background-color: #0056b3;
        }
        .buttons a {
            text-decoration: none;
        }
    </style>
</head>
<body>
<a href="/index.php" style="text-decoration: none; color: white">
    <i class="fa fa-home" style="font-size:30px;color:#f5f6f2;"></i>
    Accueil
</a>
<script>
    // Vérifier si le paramètre "success" est présent dans l'URL
    if (new URLSearchParams(window.location.search).has('success')) {
        alert('Modification effectuée avec succès');
    }
</script>
<div class="profile-container">
    <h1>Modifier mes informations</h1>
    <form method="POST" action="">
        <div class="name-field">
            <div class="input-group">
                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($userData['nom']); ?>" required>

                <label for="prenom">Prénom:</label>
                <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($userData['prenom']); ?>" required>
            </div>
        </div>
        <div class="name-field">
            <div class="input-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($userData['email']); ?>" required>

                <label for="contact">Contact:</label>
                <input type="text" id="contact" name="contact" value="<?php echo htmlspecialchars($userData['contact']); ?>" required>
            </div>
        </div>
        <div class="name-field">
            <div class="input-group">
                <label for="pays">Pays:</label>
                <input type="text" id="pays" name="pays" value="<?php echo htmlspecialchars($userData['pays']); ?>" required>

                <label for="ville">Ville:</label>
                <input type="text" id="ville" name="ville" value="<?php echo htmlspecialchars($userData['ville']); ?>" required>
            </div>
        </div>
        <div class="name-field">
            <div class="input-group">
                <label for="sexe">Sexe:</label>
                <select id="sexe" name="sexe" required>
                    <option value="M" <?php echo $userData['sexe'] == 'M' ? 'selected' : ''; ?>>Masculin</option>
                    <option value="F" <?php echo $userData['sexe'] == 'F' ? 'selected' : ''; ?>>Féminin</option>
                </select>
            </div>
        </div>
        <div class="name-field">
            <div class="input-group">
                <label for="commune">Commune:</label>
                <select id="commune" name="commune" required>
                    <?php foreach ($communes as $commune): ?>
                        <option value="<?php echo $commune['id_commune']; ?>" <?php echo $userData['commune_id'] == $commune['id_commune'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($commune['nom_commune']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="name-field">
            <div class="input-group">
                <label for="metier">Métier:</label>
                <select id="metier" name="metier" required>
                    <?php foreach ($metiers as $metier): ?>
                        <option value="<?php echo $metier['id_metier']; ?>" <?php echo $userData['metier_id'] == $metier['id_metier'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($metier['nom_metier']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="name-field">
            <div class="input-group">
                <label for="experience">Expérience (en années):</label>
                <input type="number" id="experience" name="experience" value="<?php echo htmlspecialchars($userData['anne_experience']); ?>" required>
            </div>
        </div>
        <div class="name-field">
            <div class="input-group">
                <label for="gpsData">Données GPS:</label>
                <input type="text" id="gpsData" name="gpsData" value="<?php echo htmlspecialchars($userData['gpsdata']); ?>" required>
            </div>
        </div>
        <div class="buttons">
            <button type="submit">Enregistrer les modifications</button>
            <a href="users.php">
                <button type="button">Annuler</button>
            </a>
        </div>
    </form>
</div>
</body>
</html>
