<?php
session_start();
require 'db_connexion.php'; // Connexion à la base de données
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil utilisateur</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/profil.css">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary p-3">
        <a href="annonces.php" class="navbar-brand">AnnnoncesGG</a>
        <ul class="nav navbar-nav">
            <?php if(isset($_SESSION['Courriel'])){echo '<li><a href="annonces.php">Afficher les annonces</a></li>';}?>
            <?php if(isset($_SESSION['Courriel'])){echo '<li><a href="gerer_annonces.php">Gérer mes annonces</a></li>';}?>
            <?php if(isset($_SESSION['Courriel'])){echo '<li><a href="profile.php">Mon profil</a></li>';}?>
            <?php if(isset($_SESSION['Courriel'])){echo '<li><a href="deconnexion.php">Déconnexion</a></li>';} ?>
            <?php if(!isset($_SESSION['Courriel'])){echo '<li><a href="connexion.php">Login</a></li>';}?>
            <?php if(!isset($_SESSION['Courriel'])){echo '<li><a href="enregistrement.php">Inscrire</a></li>';}?>
        </ul>
    </nav>
    <div class="container">
        <h1 class="text-center my-4">Modifier Profil</h1>
    </div>
</body>