<?php
// Connexion à la base de données
require_once 'db_connexion.php';
// Demarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if(!isset($_SESSION['Courriel'])){
    header("Location: connexion.php");
}

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
