<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "site_bd";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
// Fichier de connexion à la base de données.