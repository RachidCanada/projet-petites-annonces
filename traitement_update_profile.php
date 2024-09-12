<?php 
// Connexion à la base de données
require_once 'db_connexion.php';
// Demarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if(!isset($_SESSION['Courriel'])){
    header("Location: connexion.php");
}

    // Verifier si le formulaire a été soumis 
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // Récuperer les données du formulaire
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $telMaison = $_POST["telephone_maison"];
        $telTravail = $_POST["telephone_travail"];
        $telCellulaire = $_POST["telephone_cellulaire"];

        // Mise à jour des informations de l'utilisateur sans changer la photo ni la bio
        try {
            $sql = "UPDATE utilisateurs SET Nom = ?, Prenom = ?, NoTelMaison = ?, NoTelTravail = ?, NoTelCellulaire = ? WHERE Courriel = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$nom, $prenom, $telMaison, $telTravail, $telCellulaire, $_SESSION['Courriel']]);

            // Rediriger vers la page profil.php après la modification du profil
            header("Location: profile.php");
            exit;
        } catch (PDOException $e) {
            echo "Erreur lors de la modification du profil : " . $e->getMessage();
        }
    }
?>