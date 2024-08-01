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
        LEFT JOIN communes c ON u.commune_id = c.id_commune
        LEFT JOIN metiers m ON u.metier_id = m.id_metier
        WHERE u.id_user = :id
    ");
    $req->bindParam(':id', $id_user, PDO::PARAM_INT);
    $req->execute();
    $userData = $req->fetch(PDO::FETCH_ASSOC);

    if (!$userData) {
        die("Utilisateur non trouvé.");
    }
} catch (PDOException $e) {
    die("Erreur lors de la récupération des informations utilisateur : " . $e->getMessage());
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_account'])) {
    try {

        $deleteQuery = $connexion->prepare("DELETE FROM users WHERE id_user = :id");
        $deleteQuery->bindParam(':id', $id_user, PDO::PARAM_INT);
        $deleteQuery->execute();

        session_destroy();

        echo '<script>alert("Votre compte a été supprimé avec succès.");';
        echo 'window.location.href = "/index.php";</script>'; //
    } catch (PDOException $e) {
        die("Erreur lors de la suppression du compte : " . $e->getMessage());
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
    <title>Profil Utilisateur</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
                url('/Public/images/artisan-mecanique1.jpeg') no-repeat center center fixed;
                background-size: cover;
                color: white !important;
                margin: 0;
                height: 100vh;
                flex-direction: column;
                justify-content: center;
            }
            .profile-container {
                max-width: 900px;
                margin: 0 auto;
                padding: 100px;
                border: 1px solid #ccc;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                background-color: rgba(0, 0, 0, 0.7);
            }
            h1 {
                text-align: center;
                color: white;
            }
            p {
                margin: 20px;
                line-height: 1.6;
                color: white;
            }
            strong {
                font-weight: bold;
                color: white;
                display: inline-block;
                width: 30%;
                margin-right: 20px;
            }
            .value {
                display: inline-block;
                color: #ccc;
            }
            .button-container {
                display: flex;
                justify-content: space-between;
                margin-top: 20px;
            }
            .button-container a,
            .button-container form {
                text-align: center;
            }
            .blue-btn {
                padding: 12px 24px;
                border: none;
                border-radius: 5px;
                background-color: #007BFF;
                color: #fff;
                cursor: pointer;
                text-decoration: none;
                display: inline-block;
                text-align: center;
            }
            .delete-btn {
                padding: 12px 24px;
                border: none;
                border-radius: 5px;
                background-color: #FF0000;
                color: #fff;
                cursor: pointer;
                text-decoration: none;
                display: inline-block;
                text-align: center;
            }
            .blue-btn:hover {
                background-color: #0056b3;
            }
            .delete-btn:hover {
                background-color: #cc0000;
            }
            a {
                text-decoration: none;
                color: #007BFF;
            }
            a:hover {
                text-decoration: underline;
            }
        </style>
    </head>
<body>
<a href="/index.php" style="text-decoration: none; color: white">
    <i class="fa fa-home" style="font-size:30px;color:#ffffff;"></i>
    Accueil
</a>
<script>
    if (new URLSearchParams(window.location.search).has('success')) {
        alert('Modification effectuée avec succès');
    }

    function confirmDeletion() {
        if (confirm('Êtes-vous sûr de vouloir supprimer votre compte ? Vos informations liées à cette application seront supprimées.')) {

            document.getElementById('deleteForm').submit();
        }
        return false;
    }
</script>

<h1>Profil Utilisateur</h1>

<div class="profile-container">
    <p><strong>Nom :</strong> <span class="value"><?php echo htmlspecialchars($userData['nom']); ?></span></p>
    <p><strong>Prénom :</strong> <span class="value"><?php echo htmlspecialchars($userData['prenom']); ?></span></p>
    <p><strong>Email :</strong> <span class="value"><?php echo htmlspecialchars($userData['email']); ?></span></p>
    <p><strong>Sexe :</strong> <span class="value"><?php echo htmlspecialchars($userData['sexe']); ?></span></p>
    <p><strong>Contact :</strong> <span class="value"><?php echo htmlspecialchars($userData['contact']); ?></span></p>
    <p><strong>Pays :</strong> <span class="value"><?php echo htmlspecialchars($userData['pays']); ?></span></p>
    <p><strong>Ville :</strong> <span class="value"><?php echo htmlspecialchars($userData['ville']); ?></span></p>
    <p><strong>Commune :</strong> <span class="value"><?php echo htmlspecialchars($userData['nom_commune']); ?></span></p>
    <p><strong>Métier :</strong> <span class="value"><?php echo htmlspecialchars($userData['nom_metier']); ?></span></p>
    <p><strong>Expérience :</strong> <span class="value"><?php echo htmlspecialchars($userData['anne_experience']); ?> ans</span></p>
    <p><strong>Données GPS :</strong> <span class="value"><?php echo htmlspecialchars($userData['gpsdata']); ?></span></p>

    <div class="button-container">
        <a href="edit_profile.php" class="blue-btn">Modifier mes informations</a>
        <form id="deleteForm" method="POST" action="" onsubmit="return confirmDeletion();">
            <input type="hidden" name="delete_account" value="1">
            <button type="submit" class="delete-btn">Supprimer mon compte</button>
        </form>
    </div>
</div>

</body>
</html>
