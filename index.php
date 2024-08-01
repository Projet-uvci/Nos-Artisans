<?php
session_start();

if (!isset($_SESSION['visited'])) {
    $_SESSION['visited'] = true;
    header('Location: anime_page.php');
    exit;
}

include 'Vue/Partie/header.php';
include 'Vue/Partie/home.php';
include 'Vue/Partie/pied.php';

