<?php
session_start();
require 'db_connexion.php'; // Connexion à la base de données

if (isset($_GET['no'])) {
    $noAnnonce = $_GET['no'];

    // Supprimer l'annonce
    $stmt = $conn->prepare("DELETE FROM annonces WHERE NoAnnonce = :noAnnonce");
    $stmt->bindParam(':noAnnonce', $noAnnonce, PDO::PARAM_INT);
    $stmt->execute();

    // Rediriger vers la liste des annonces après suppression
    header('Location: annonces.php');
    exit;
} else {
    echo "Numéro d'annonce manquant.";
}
?>
