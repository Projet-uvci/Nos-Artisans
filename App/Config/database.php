<?php
try {
    $dsn = 'mysql:host=mysql-entreprise75.alwaysdata.net;dbname=entreprise75_site_db';
    $connexion = new PDO($dsn, '370480_entrp75', 're2A7_RLeKTDn63');
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
?>

