<?php
require '../../../App/Config/database.php';
require_once '../../../config.php';
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $communeId = $_POST['commune'] ?? null;
    $metierId = $_POST['metier'] ?? null;
    $nom = $_POST['nom'] ?? '';
    $prenoms = $_POST['prenoms'] ?? '';
    $telephone = $_POST['telephone'] ?? '';
    $email = $_POST['email'] ?? '';
    $description = $_POST['description'] ?? '';
    $dates = $_POST['dates'] ?? '';
    $horaires = $_POST['horaires'] ?? '';
    $montant = 2000;

    $imageData = null;
    if (!empty($_FILES['image']['tmp_name'])) {
        $imageData = file_get_contents($_FILES['image']['tmp_name']);
        if ($imageData) {
            echo "Image téléchargée avec succès.";
        } else {
            echo "Erreur lors de la lecture de l'image.";
        }
    } else {
        echo "Aucune image sélectionnée.";
    }

    try {
        $stmt = $connexion->prepare("INSERT INTO interventions (nom, prenoms, numero, email, contact, intervention, date_intervention, heure_intervention, commune_id, metier_id, image, prix_intervention) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $result =  $stmt->execute([$nom, $prenoms, $telephone, $email, $telephone, $description, $dates, $horaires, $communeId, $metierId, $imageData, $montant]);
        if ($result) {
            echo "<script>
                    alert('Réservation enregistrée avec succès!');
                    window.location.href = '../../../index.php';
                </script>";
        }else{
            $message = "Erreur lors de l'enregistrement.";
        }
    } catch (PDOException $e) {
        die("Erreur lors de l'enregistrement de la réservation : " . $e->getMessage());
    }
}
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="/Public/images/log75.jpeg">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://js.stripe.com/v3/"></script>
    <title>Réservation d'une prestation</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<a href="/index.php" style="text-decoration: none; color: #1c1a1a">
    <i class="fa fa-home" style="font-size:30px;color:#392f2f;"></i>
    Accueil
</a>
<div class="container">
    <div class="cart">
        <form id="commandeForm" method="post">
            <a name="anchor"></a>
            <div class="row cart-table-row cart-table-row-head">
                <div class="col-xs-8 text-right-center">
                   <h1>TOP C'EST BON VOUS POUVEZ FAIRE VOTRE RESERVATION</h1>
                </div>
            </div>
            <br>
            <br>
            <br>
            <div class="row">
                <select name="commune" id="commune" class="col-xs-12" style="font-size: 15px; height: 45px;" required>
                    <option value="">Sélectionner la commune de l'intervention</option>
                    <?php foreach ($communes as $commune): ?>
                        <option value="<?php echo htmlspecialchars($commune['id_commune']); ?>"><?php echo htmlspecialchars($commune['nom_commune']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <br>
            <br>
            <div class="row">
                <select name="metier" id="metier" class="col-xs-12" style="font-size: 15px; height: 45px;" required>
                    <option value="">Sélectionner le secteur d'activité</option>
                    <?php foreach ($metiers as $metier): ?>
                        <option value="<?php echo htmlspecialchars($metier['id_metier']); ?>"><?php echo htmlspecialchars($metier['nom_metier']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <br>
            <br>
            <div class="row cart-table-row cart-table-row-total cart-table-row-head" style="background: #FF5520;">
                <div class="col-xs-8" style="color: white" >
                    LA SOMME DÉJÀ VERSER POUR LA PRISE DE RENDEZ-VOUS
                </div>
                <div class="col-xs-4 text-right" style="color: white">
                    <strong style="font-size: 20px;"> 2000 FCFA</strong>
                    <input type="hidden" name="montant" value="2000">
                </div>
            </div>

            <br><br><br><br>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <h2 class="cart-title"><i class="fa fa-user" aria-hidden="true"></i> Informations personnelles <b style="font-size: 15px; color: red;">(Demandeur)</b></h2>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="container-fluid">
                        <div class="row form-group has-feedback">
                            <div class="col-xs-12">
                                <div class="row">
                                    <div class="col-xs-12 col-md-4 col-lg-3">
                                        <label for="nom" class="required">Nom</label>
                                    </div>
                                    <div class="positionRelative col-xs-12 col-md-8 col-lg-9">
                                        <input type="text" id="nom" name="nom" placeholder="Votre Nom" class="form-control">
                                        <span class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="container-fluid">
                        <div class="row form-group has-feedback">
                            <div class="col-xs-12">
                                <div class="row">
                                    <div class="col-xs-12 col-md-4 col-lg-3">
                                        <label for="prenoms" class="required">Prénoms</label>
                                    </div>
                                    <div class="positionRelative col-xs-12 col-md-8 col-lg-9">
                                        <input type="text" id="prenoms" name="prenoms" placeholder="Vos Prénoms" class="form-control">
                                        <span class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="container-fluid">
                        <div class="row form-group has-feedback">
                            <div class="col-xs-12">
                                <div class="row">
                                    <div class="col-xs-12 col-md-4 col-lg-3">
                                        <label for="telephone" class="required">Téléphone</label>
                                    </div>
                                    <div class="positionRelative col-xs-12 col-md-8 col-lg-9">
                                        <input type="text" id="telephone" name="telephone" placeholder="Votre numéro de téléphone principal" class="form-control" required>
                                        <span class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="container-fluid">
                        <div class="row form-group has-feedback">
                            <div class="col-xs-12">
                                <div class="row">
                                    <div class="col-xs-12 col-md-4 col-lg-3">
                                        <label for="email">Email </label><i style="font-size: 10px; color: red;">(Facultatif)</i>
                                    </div>
                                    <div class="positionRelative col-xs-12 col-md-8 col-lg-9">
                                        <input type="email" id="email" name="email" placeholder="Votre adresse email si vous en avez..." class="form-control"required>
                                        <span class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <h2 class="cart-title">En cas d’absence, personne à contacter <b style="font-size: 15px; color: red;">(S'il s'agit de vous, entrez à nouveau vos informations svp !)</b></h2>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="container-fluid">
                        <div class="row form-group has-feedback">
                            <div class="col-xs-12">
                                <div class="row">
                                    <div class="col-xs-12 col-md-4 col-lg-3">
                                        <label for="noms">Nom & Prénoms</label>*
                                    </div>
                                    <div class="positionRelative col-xs-12 col-md-8 col-lg-9">
                                        <input type="text" id="noms" name="noms" placeholder="La personne à contacter au cas où la personne qui fait la réservation sera absente lors de la réalisation de l'intervention !" class="form-control" required>
                                        <span class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="container-fluid">
                        <div class="row form-group has-feedback">
                            <div class="col-xs-12">
                                <div class="row">
                                    <div class="col-xs-12 col-md-4 col-lg-3">
                                        <label for="telephones" class="required">Numéro(s) de téléphone(s)</label>*
                                    </div>
                                    <div class="positionRelative col-xs-12 col-md-8 col-lg-9">
                                        <input type="text" id="telephones" name="telephones" placeholder="Numéro de téléphones" class="form-control" required>
                                        <span class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br><br>
                        <hr>
                    </div>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <h2 class="cart-title"><i class="fa fa-home" aria-hidden="true"></i> Informations complémentaires pour l’intervention</h2>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="container-fluid">
                        <div class="row form-group has-feedback">
                            <div class="col-xs-12">
                                <div class="row">
                                    <div class="col-xs-12 col-md-5 col-lg-4">
                                        <label class="control-label required" for="intervention">Nous voulons en savoir plus sur l’intervention *</label>
                                    </div>
                                    <div class="positionRelative col-xs-12 col-md-7 col-lg-8">
                                        <textarea name="description" placeholder="Decrivez votre besoin, quels travaux souhaitez-vous réaliser donnez nous nous tout les détailles pour nous aider à vous satisfaire. Soyez précis et concis..." class="form-control"required></textarea>
                                        <span class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="container-fluid">
                        <div class="row form-group has-feedback">
                            <div class="col-xs-12">
                                <div class="row">
                                    <div class="col-xs-12 col-md-5 col-lg-4">
                                        <label class="control-label" for="intervention">Ajouter des photos pour expliquer au mieux votre besoin</label>
                                    </div>
                                    <div class="positionRelative col-xs-12 col-md-7 col-lg-8">
                                        <input type="file" id="image" name="image" accept="image/*" class="form-control">
                                        <span class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="container-fluid">
                        <div class="row form-group has-feedback">
                            <div class="col-xs-12">
                                <div class="row">
                                    <div class="col-xs-12 col-md-5 col-lg-4">
                                        <label class="control-label required" for="dates">Votre date de disponibilité pour l’intervention </label>
                                    </div>
                                    <div class="positionRelative col-xs-12 col-md-7 col-lg-8">
                                        <input type="date" id="dates" name="dates" placeholder="Veuillez entrer votre date de disponibilité pour la réalisation des travaux" class="form-control">
                                        <span class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="container-fluid">
                        <div class="row form-group has-feedback">
                            <div class="col-xs-12">
                                <div class="row">
                                    <div class="col-xs-12 col-md-5 col-lg-4">
                                        <label class="control-label required" for="horaires">Heure de passage souhaitée *</label>
                                    </div>
                                    <div class="positionRelative col-xs-12 col-md-7 col-lg-8">
                                        <input type="time" id="horaires" name="horaires" class="form-control">
                                        <span class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 text-right">
                    <button class="stripe-button btn btn-default" id="payButton">
                        <div class="spinner hidden" id="spinner"></div>
                        <span id="buttonText">Réserver maintenant</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>