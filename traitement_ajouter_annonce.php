<?php
// Connexion à la base de données
require_once 'db_connexion.php';
// Demarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if(!isset($_SESSION['Courriel'])){
    header("Location: connexion.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $descriptionAbregee = $_POST['descriptionAbregee'];
    $descriptionComplete = $_POST['descriptionComplete'];
    $prix = $_POST['prix'];
    $noUtilisateur = 1; // Remplacez par $_SESSION['NoUtilisateur'] si l'utilisateur est connecté

    // Vérifier que tous les champs obligatoires sont présents
    if (!empty($descriptionAbregee) && !empty($descriptionComplete) && !empty($prix) && !empty($_FILES['photo']['name'])) {
        // Gestion du fichier photo
        $target_dir = "photos-annonce/";
        $photo = basename($_FILES['photo']['name']);
        $target_file = $target_dir . $photo;

        // Vérifier que l'upload de la photo a réussi
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
            // Requête d'insertion
            $stmt = $conn->prepare("INSERT INTO annonces (DescriptionAbregee, DescriptionComplete, Prix, Photo, NoUtilisateur, Etat, Parution)
                                    VALUES (:descriptionAbregee, :descriptionComplete, :prix, :photo, :noUtilisateur, 1, NOW())");

            $stmt->bindParam(':descriptionAbregee', $descriptionAbregee);
            $stmt->bindParam(':descriptionComplete', $descriptionComplete);
            $stmt->bindParam(':prix', $prix);
            $stmt->bindParam(':photo', $photo);
            $stmt->bindParam(':noUtilisateur', $noUtilisateur);

            if ($stmt->execute()) {
                // Redirection en cas de succès
                header('Location: annonces.php');
                exit();
            } else {
                echo "Erreur lors de l'insertion de l'annonce.";
            }
        } else {
            echo "Erreur lors du téléchargement de la photo.";
        }
    } else {
        echo "Tous les champs sont obligatoires.";
    }
}
?>
