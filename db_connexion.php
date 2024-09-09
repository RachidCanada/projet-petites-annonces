<?php
// Paramètres de connexion à la base de données
$servername = "localhost";
$username = "root"; // Utilisateur MySQL par défaut dans XAMPP
$password = ""; // Mot de passe par défaut pour root (vide)
$dbname = "petites_annonces"; // Votre base de données

// Création de la connexion
try {
    // Connexion avec la définition du charset UTF-8
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    // Configurer PDO pour lever des exceptions en cas d'erreur
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Message optionnel pour confirmer la connexion
    // echo "Connexion réussie à la base de données";
} catch (PDOException $e) {
    // En cas d'erreur, afficher un message et arrêter le script
    die("Erreur de connexion : " . $e->getMessage());
}
?>
