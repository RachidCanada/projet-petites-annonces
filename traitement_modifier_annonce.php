<?php
// Connexion à la base de données
require_once 'db_connexion.php';
// Demarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if(!isset($_SESSION['Courriel'])){
    header("Location: connexion.php");
}

if (isset($_POST['NoAnnonce'])) {
    // Récupérer les données postées et les filtrer pour éviter les injections SQL
    $noAnnonce = filter_input(INPUT_POST, 'NoAnnonce', FILTER_SANITIZE_NUMBER_INT);
    $descriptionAbregee = filter_input(INPUT_POST, 'DescriptionAbregee', FILTER_SANITIZE_STRING);
    $descriptionComplete = filter_input(INPUT_POST, 'DescriptionComplete', FILTER_SANITIZE_STRING);
    $prix = filter_input(INPUT_POST, 'Prix', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

    // Vérifier si un fichier a été uploadé
    $photo = $_FILES['Photo']['name'];
    
    // Gérer l'upload de la nouvelle photo si elle est modifiée
    if (!empty($photo)) {
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $extension = pathinfo($photo, PATHINFO_EXTENSION);

        // Vérifier l'extension de l'image
        if (in_array(strtolower($extension), $allowedExtensions)) {
            $target_dir = "photos-annonce/";
            $target_file = $target_dir . basename($photo);

            if (move_uploaded_file($_FILES["Photo"]["tmp_name"], $target_file)) {
                // Succès de l'upload
                // Supprimer l'ancienne image si nécessaire
            } else {
                echo "Erreur lors de l'upload de la photo.";
                exit();
            }
        } else {
            echo "Format de fichier non supporté. Veuillez télécharger une image au format jpg, jpeg, png ou gif.";
            exit();
        }
    } else {
        // Si aucune nouvelle image n'a été envoyée, conserver l'image actuelle
        $stmt = $conn->prepare("SELECT Photo FROM annonces WHERE NoAnnonce = :noAnnonce");
        $stmt->bindParam(':noAnnonce', $noAnnonce, PDO::PARAM_INT);
        $stmt->execute();
        $annonce = $stmt->fetch(PDO::FETCH_ASSOC);
        $photo = $annonce['Photo'];
    }

    // Mettre à jour l'annonce dans la base de données
    $stmt = $conn->prepare("UPDATE annonces SET 
                                DescriptionAbregee = :descriptionAbregee, 
                                DescriptionComplete = :descriptionComplete, 
                                Prix = :prix, 
                                Photo = :photo 
                            WHERE NoAnnonce = :noAnnonce");
    $stmt->bindParam(':descriptionAbregee', $descriptionAbregee);
    $stmt->bindParam(':descriptionComplete', $descriptionComplete);
    $stmt->bindParam(':prix', $prix);
    $stmt->bindParam(':photo', $photo);
    $stmt->bindParam(':noAnnonce', $noAnnonce, PDO::PARAM_INT);

    if ($stmt->execute()) {
        // Rediriger vers la liste des annonces en cas de succès
        header('Location: annonces.php');
        exit();
    } else {
        echo "Erreur lors de la mise à jour de l'annonce.";
    }
} else {
    echo "Données manquantes.";
}
?>
