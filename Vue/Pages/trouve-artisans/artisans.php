<?php
session_start();

require_once '../../../App/Config/database.php';

try {
    $req = $connexion->prepare("SELECT * FROM metiers");
    $req->execute();
    $metiers = $req->fetchAll();
} catch (PDOException $e) {
    die("Erreur lors de la récupération des métiers : " . $e->getMessage());
}

try {
    $req = $connexion->prepare("SELECT * FROM communes");
    $req->execute();
    $communes = $req->fetchAll();
} catch (PDOException $e) {
    die("Erreur lors de la récupération des communes : " . $e->getMessage());
}

// Définir les paramètres de pagination
$limit = 12; //
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $secteur = $_POST['secteur'];
    $commune = $_POST['commune'];

    try {
        $req = $connexion->prepare("
            SELECT u.*, m.nom_metier, c.nom_commune
            FROM users u
            LEFT JOIN metiers m ON u.metier_id = m.id_metier
            LEFT JOIN communes c ON u.commune_id = c.id_commune
            WHERE u.metier_id = :secteur AND u.commune_id = :commune
            LIMIT :limit OFFSET :offset
        ");
        $req->bindParam(':secteur', $secteur, PDO::PARAM_INT);
        $req->bindParam(':commune', $commune, PDO::PARAM_INT);
        $req->bindParam(':limit', $limit, PDO::PARAM_INT);
        $req->bindParam(':offset', $offset, PDO::PARAM_INT);
        $req->execute();
        $users = $req->fetchAll();


        if (!$users) {
            die("Aucun artisan trouvé pour les critères spécifiés.");
        }
    } catch (PDOException $e) {
        die("Erreur lors de la récupération des informations : " . $e->getMessage());
    }
} else {

    try {
        $req = $connexion->prepare("
            SELECT u.*, m.nom_metier, c.nom_commune
            FROM users u
            LEFT JOIN metiers m ON u.metier_id = m.id_metier
            LEFT JOIN communes c ON u.commune_id = c.id_commune
            LIMIT :limit OFFSET :offset
        ");
        $req->bindParam(':limit', $limit, PDO::PARAM_INT);
        $req->bindParam(':offset', $offset, PDO::PARAM_INT);
        $req->execute();
        $users = $req->fetchAll();
    } catch (PDOException $e) {
        die("Erreur lors de la récupération des informations : " . $e->getMessage());
    }
}


try {
    $req = $connexion->prepare("SELECT COUNT(*) FROM users");
    $req->execute();
    $total_users = $req->fetchColumn();
    $total_pages = ceil($total_users / $limit);
} catch (PDOException $e) {
    die("Erreur lors de la récupération du nombre total d'utilisateurs : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="/Public/images/log75.jpeg">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Recherche d'artisan</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
<?php require_once __DIR__ . '/../../Partie/header.php';?>
<section>
    <div class="max-w-screen-xl px-4 py-8 mx-auto text-center lg:py-24 lg:px-6">
        <form id="form-projet" method="POST">
            <div class="col-md-2 col-sm-12 col-xs-12">
                <h1 style="font-size: 20px; text-align: center; color: #FF5520;">Trouver un artisan</h1>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12 form-group has-feedback">
                <select name="secteur" id="secteur" class="fullWidth form-control" required style="font-size: 15px; height: 45px;">
                    <option value="">Sélectionner le secteur d'activité</option>
                    <?php foreach ($metiers as $metier): ?>
                        <option value="<?php echo htmlspecialchars($metier['id_metier']); ?>"><?php echo htmlspecialchars($metier['nom_metier']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12 form-group has-feedback">
                <select name="commune" id="commune" class="fullWidth form-control" required style="font-size: 15px; height: 45px;">
                    <option value="">Sélectionner la commune de l'intervention</option>
                    <?php foreach ($communes as $commune): ?>
                        <option value="<?php echo htmlspecialchars($commune['id_commune']); ?>"><?php echo htmlspecialchars($commune['nom_commune']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2 col-sm-12 col-xs-12">
                <button class="btn btnOrange fullWidth" type="submit" name="search">Trouver</button>
            </div>
        </form>
    </div>
</section>
<div class="container" style="background: white">
    <div id="artisan-list">
        <div class="row">
            <?php if (!empty($users)): ?>
                <!-- Section des résultats -->
                <div class="main-section">
                    <?php foreach ($users as $user): ?>
                        <div class="artisan" >
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="block-prohead">
                                        <div class="block-societe">
                                            <p class="label-societe"><?php echo htmlspecialchars($user['nom']) . ' ' . htmlspecialchars($user['prenom']); ?></p><br>
                                        </div>
                                        <div class="block-phone">
                                            <div class="hide-phone">Expérience Pro :<?php echo htmlspecialchars($user['anne_experience']); ?> ans</div>
                                        </div>
                                        <img class="logo-artisan img-circle" src="/Public/images/avatar-201116-2cef22e841.png" alt="Photo de l'artisan">
                                    </div>
                                    <div class="block-activity">
                                        <span class="block-activity-title">Métiers</span><br>
                                        <div class="project-type">
                                            <div class="project-type-label"><?php echo htmlspecialchars($user['nom_metier']); ?></div>
                                        </div>
                                    </div>
                                    <div class="block-activity">
                                        <span class="block-activity-title">Lieux Interventions</span><br>
                                        <div class="project-type">
                                            <div class="project-type-label"><?php echo htmlspecialchars($user['nom_commune']); ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <a class="block-profile" href="tel:<?php echo htmlspecialchars($user['contact']); ?>">
                                        <i class="fa fa-phone" id="blink" aria-hidden="true"></i> <b>Appelez maintenant</b>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <!-- Pagination -->
                <div class="pagination" style="text-align: center;">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?php echo $page - 1; ?>" class="btn btn-primary" style="float: left;">Précédent</a>
                    <?php endif; ?>

                    <?php if ($page < $total_pages): ?>
                        <a href="?page=<?php echo $page + 1; ?>" class="btn btn-primary" style="float: right;">Suivant</a>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <p>Aucun artisan trouvé pour les critères spécifiés.</p>
            <?php endif; ?>
        </div>
        <!-- Section 1 -->

    </div>
</div>
</body>
</html>
