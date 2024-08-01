<?php
try {
    // pour la base de données en ligne ( non utilisateur:370480_entrp75, mot de passe: re2A7_RLeKTDn63) lien:https://phpmyadmin.alwaysdata.com/
    $connexion = new PDO('mysql:host=localhost;dbname=site_bd', 'root', 'Entreprise75!');
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
?>
