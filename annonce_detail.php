<?php
session_start();
require 'db_connexion.php'; // Connexion à la base de données

if (isset($_GET['no'])) {
    $noAnnonce = $_GET['no'];

    // Requête pour récupérer les détails de l'annonce
    $stmt = $conn->prepare("SELECT a.DescriptionAbregee, a.DescriptionComplete, a.Prix, a.Photo, u.Nom, u.Prenom, a.Parution 
                            FROM annonces a 
                            JOIN utilisateurs u ON a.NoUtilisateur = u.NoUtilisateur 
                            WHERE a.NoAnnonce = :noAnnonce");
    $stmt->bindParam(':noAnnonce', $noAnnonce, PDO::PARAM_INT);
    $stmt->execute();
    $annonce = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($annonce) {
        // Afficher les détails de l'annonce
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <title>Détail de l'annonce</title>
            <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
            <link rel="stylesheet" href="styles.css">
        </head>
        <body>
            <div class="container">
                <h1 class="my-4"><?php echo htmlspecialchars($annonce['DescriptionAbregee'], ENT_QUOTES, 'UTF-8'); ?></h1>
                <img src="photos-annonce/<?php echo htmlspecialchars($annonce['Photo'], ENT_QUOTES, 'UTF-8'); ?>" alt="Image annonce" class="img-fluid mb-3">
                <p><?php echo htmlspecialchars($annonce['DescriptionComplete'], ENT_QUOTES, 'UTF-8'); ?></p>
                <p><strong>Prix : </strong><?php echo htmlspecialchars($annonce['Prix'], ENT_QUOTES, 'UTF-8'); ?> $</p>
                <p><strong>Publié par : </strong><?php echo htmlspecialchars($annonce['Nom'] . ' ' . $annonce['Prenom'], ENT_QUOTES, 'UTF-8'); ?></p>
                <p><strong>Date de publication : </strong><?php echo htmlspecialchars(date('d/m/Y', strtotime($annonce['Parution'])), ENT_QUOTES, 'UTF-8'); ?></p>

                <!-- Boutons Modifier et Supprimer pour l'auteur de l'annonce -->
                <a href="modifier_annonce.php?no=<?php echo $noAnnonce; ?>" class="btn btn-primary">Modifier</a>
                <a href="supprimer_annonce.php?no=<?php echo $noAnnonce; ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?');">Supprimer</a>
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
