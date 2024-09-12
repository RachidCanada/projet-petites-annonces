<?php
session_start();
require 'db_connexion.php'; // Connexion à la base de données

if (isset($_GET['no'])) {
    $noAnnonce = $_GET['no'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Récupérer les nouvelles données du formulaire
        $descriptionAbregee = filter_input(INPUT_POST, 'descriptionAbregee', FILTER_SANITIZE_STRING);
        $descriptionComplete = filter_input(INPUT_POST, 'descriptionComplete', FILTER_SANITIZE_STRING);
        $prix = filter_input(INPUT_POST, 'prix', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

        // Vérifier si un fichier a été uploadé
        $photo = $_FILES['photo']['name'];
        
        // Gérer l'upload de la nouvelle photo si elle est modifiée
        if (!empty($photo)) {
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            $extension = pathinfo($photo, PATHINFO_EXTENSION);

            // Vérifier l'extension de l'image
            if (in_array(strtolower($extension), $allowedExtensions)) {
                $target_dir = "photos-annonce/";
                $target_file = $target_dir . basename($photo);

                if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                    // Succès de l'upload
                } else {
                    echo "Erreur lors de l'upload de la photo.";
                    exit();
                }
            } else {
                echo "Format de fichier non supporté. Veuillez télécharger une image.";
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
        $stmt = $conn->prepare("UPDATE annonces 
                                SET DescriptionAbregee = :descriptionAbregee, 
                                    DescriptionComplete = :descriptionComplete, 
                                    Prix = :prix, 
                                    Photo = :photo 
                                WHERE NoAnnonce = :noAnnonce");
        $stmt->bindParam(':descriptionAbregee', $descriptionAbregee);
        $stmt->bindParam(':descriptionComplete', $descriptionComplete);
        $stmt->bindParam(':prix', $prix);
        $stmt->bindParam(':photo', $photo);
        $stmt->bindParam(':noAnnonce', $noAnnonce, PDO::PARAM_INT);
        $stmt->execute();

        // Redirection après la modification
        header('Location: annonce_detail.php?no=' . $noAnnonce);
        exit;
    }

    // Récupérer les détails actuels de l'annonce
    $stmt = $conn->prepare("SELECT DescriptionAbregee, DescriptionComplete, Prix, Photo FROM annonces WHERE NoAnnonce = :noAnnonce");
    $stmt->bindParam(':noAnnonce', $noAnnonce, PDO::PARAM_INT);
    $stmt->execute();
    $annonce = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($annonce) {
        // Afficher le formulaire de modification
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <title>Modifier l'annonce</title>
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
                <h1 class="my-4">Modifier l'annonce</h1>
                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="descriptionAbregee">Description abrégée</label>
                        <input type="text" class="form-control" id="descriptionAbregee" name="descriptionAbregee" value="<?php echo htmlspecialchars($annonce['DescriptionAbregee']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="descriptionComplete">Description complète</label>
                        <textarea class="form-control" id="descriptionComplete" name="descriptionComplete" rows="5" required><?php echo htmlspecialchars($annonce['DescriptionComplete']); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="prix">Prix</label>
                        <input type="number" class="form-control" id="prix" name="prix" value="<?php echo htmlspecialchars($annonce['Prix']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="photo">Photo actuelle</label><br>
                        <img src="photos-annonce/<?php echo htmlspecialchars($annonce['Photo'], ENT_QUOTES, 'UTF-8'); ?>" alt="Image annonce" style="width: 100px;">
                        <input type="file" class="form-control-file" id="photo" name="photo">
                    </div>
                    <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                </form>
            </div>
        </body>
        </html>
        <?php
    } else {
        echo "Annonce non trouvée.";
    }
} else {
    echo "Numéro d'annonce manquant.";
}
?>
