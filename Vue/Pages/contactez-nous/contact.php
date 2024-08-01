<?php
require '../../../App/Config/database.php';
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = htmlspecialchars($_POST['nom']);
    $email = htmlspecialchars($_POST['email']);
    $sujet = htmlspecialchars($_POST['sujet']);
    $message = htmlspecialchars($_POST['message']);

    $sql = "INSERT INTO contacts (nom, email, sujet, message) VALUES (:nom, :email, :sujet, :message)";
    $stmt = $connexion->prepare($sql);

    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':sujet', $sujet);
    $stmt->bindParam(':message', $message);

    if ($stmt->execute()) {
        echo "<script>
                    alert('Message envoyé avec succès.');
                    window.location.href = '../../../index.php';
                </script>";
    } else {
        echo "Erreur lors de l'envoi du message.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="/Public/images/log75.jpeg">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Contactez nous</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
<a href="/index.php" style="text-decoration: none; color: #1c1a1a">
    <i class="fa fa-home" style="font-size:30px;color:#392f2f;"></i>
    Accueil
</a>
<div class="gdlr-core-pbf-wrapper" style="padding: 90px 0px 35px 0px;">
    <div class="gdlr-core-pbf-background-wrap" style="background-color: #ffffff;"></div>
    <div class="gdlr-core-pbf-wrapper-content gdlr-core-js">
        <div class="gdlr-core-pbf-wrapper-container clearfix gdlr-core-container">
            <div class="gdlr-core-pbf-column gdlr-core-column-60 gdlr-core-column-first" data-skin="Contact Field" id="gdlr-core-column-3">
                <div class="gdlr-core-pbf-column-content-margin gdlr-core-js">
                    <div class="gdlr-core-pbf-background-wrap"></div>
                    <div class="gdlr-core-pbf-column-content clearfix gdlr-core-js" style="max-width: 760px;">
                        <div class="gdlr-core-pbf-element">
                            <div class="gdlr-core-title-item gdlr-core-item-pdb clearfix gdlr-core-center-align gdlr-core-title-item-caption-bottom gdlr-core-item-pdlr" style="padding-bottom: 60px;">
                                <div class="gdlr-core-title-item-title-wrap">
                                    <h3 class="gdlr-core-title-item-title gdlr-core-skin-title class-test" style="font-size: 39px; font-weight: 600; letter-spacing: 0px; text-transform: none;">
                                        Laissez-nous vos informations
                                        <span class="gdlr-core-title-item-title-divider gdlr-core-skin-divider"></span>
                                    </h3>
                                </div>
                                <span class="gdlr-core-title-item-caption gdlr-core-info-font gdlr-core-skin-caption" style="font-size: 19px; font-style: normal; letter-spacing: 0px;">et nous vous répondrons !</span>
                            </div>
                        </div>
                        <div class="gdlr-core-pbf-element">
                            <div class="gdlr-core-contact-form-7-item gdlr-core-item-pdlr gdlr-core-item-pdb">
                                <form action="" method="post" class="wpcf7-form init" aria-label="Contact form">
                                    <div class="gdlr-core-input-wrap gdlr-core-full-width gdlr-core-no-border gdlr-core-with-column">
                                        <div class="gdlr-core-column-30">
                                            <p>
                                                <label>
                                                    <input size="40" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required" aria-required="true" aria-invalid="false" placeholder="Nom Complet*" value="" type="text" name="nom" required>
                                                </label>
                                            </p>
                                        </div>
                                        <div class="gdlr-core-column-30">
                                            <p>
                                                <label>
                                                    <input size="40" class="wpcf7-form-control wpcf7-email wpcf7-validates-as-required wpcf7-text wpcf7-validates-as-email" aria-required="true" aria-invalid="false" placeholder="Adresse mail*" value="" type="email" name="email" required>
                                                </label>
                                            </p>
                                        </div>
                                        <div class="clear"></div>
                                        <div class="gdlr-core-column-60">
                                            <p>
                                                <label>
                                                    <input size="40" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required" aria-required="true" aria-invalid="false" placeholder="Sujet du message*" value="" type="text" name="sujet" required>
                                                </label>
                                            </p>
                                        </div>
                                        <div class="clear"></div>
                                        <div class="gdlr-core-column-60">
                                            <p>
                                                <label>
                                                    <textarea cols="40" rows="10" class="wpcf7-form-control wpcf7-textarea wpcf7-validates-as-required" aria-required="true" aria-invalid="false" placeholder="Message*" name="message" required></textarea>
                                                </label>
                                            </p>
                                        </div>
                                        <div class="gdlr-core-column-60 gdlr-core-left-align name-field">
                                            <button type="submit" class="wpcf7-submit">Envoyer</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
