<?php
session_start();
require 'db_connexion.php'; // Connexion à la base de données

try {
    // Récupérer les annonces actives
    $stmt = $conn->prepare("SELECT a.NoAnnonce, a.DescriptionAbregee, a.Prix, u.Nom, u.Prenom, a.Parution, a.Photo 
                            FROM annonces a 
                            JOIN utilisateurs u ON a.NoUtilisateur = u.NoUtilisateur 
                            WHERE a.Etat = 1 
                            ORDER BY a.Parution DESC 
                            LIMIT 10");
    $stmt->execute();
    $annonces = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors de la récupération des annonces : " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des annonces - Petites annonces GG</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary p-3">
        <a href="annonces.php" class="navbar-brand">AnnnoncesGG</a>
        <ul class="nav navbar-nav">
            <?php if(isset($_SESSION['Courriel'])){echo '<li><a href="annonces.php">Afficher les annonces</a></li>';}?>
            <?php if(isset($_SESSION['Courriel'])){echo '<li><a href="gerer_annonces.php">Gérer mes annonces</a></li>';}?>
            <?php if(isset($_SESSION['Courriel'])){echo '<li><a href="profil.php">Mon profil</a></li>';}?>
            <?php if(isset($_SESSION['Courriel'])){echo '<li><a href="deconnexion.php">Déconnexion</a></li>';} ?>
            <?php if(!isset($_SESSION['Courriel'])){echo '<li><a href="connexion.php">login</a></li>';}?>
            <?php if(!isset($_SESSION['Courriel'])){echo '<li><a href="enregistrement.php">s\'inscrire</a></li>';}?>
        </ul>
    </nav>
    <div class="container">
        <h1 class="text-center my-4">Dernières annonces</h1>
        
        <!-- Bouton Ajouter une annonce -->
        <div class="text-right mb-4">
            <a href="ajouter_annonce.php" class="btn btn-success">Ajouter une annonce</a>
        </div>

        <?php if (count($annonces) > 0): ?>
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Description</th>
                    <th>Prix</th>
                    <th>Auteur</th>
                    <th>Date</th>
                    <th>Actions</th> <!-- Colonne pour modifier et supprimer -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($annonces as $index => $annonce): ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td>
                        <img src="photos-annonce/<?php echo htmlspecialchars($annonce['Photo'], ENT_QUOTES, 'UTF-8'); ?>" 
                             alt="Image annonce" 
                             style="width: 100px; height: auto;">
                    </td>
                    <td>
                        <a href="annonce_detail.php?no=<?php echo htmlspecialchars($annonce['NoAnnonce'], ENT_QUOTES, 'UTF-8'); ?>">
                            <?php echo htmlspecialchars($annonce['DescriptionAbregee'], ENT_QUOTES, 'UTF-8'); ?>
                        </a>
                    </td>
                    <td><?php echo htmlspecialchars($annonce['Prix'], ENT_QUOTES, 'UTF-8'); ?> $</td>
                    <td><?php echo htmlspecialchars($annonce['Nom'] . ' ' . $annonce['Prenom'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars(date('d/m/Y', strtotime($annonce['Parution'])), ENT_QUOTES, 'UTF-8'); ?></td>

                    <!-- Colonne Actions pour modifier et supprimer -->
                    <td>
                        <a href="modifier_annonce.php?no=<?php echo $annonce['NoAnnonce']; ?>" class="btn btn-primary btn-sm">Modifier</a>
                        <a href="supprimer_annonce.php?no=<?php echo $annonce['NoAnnonce']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?');">Supprimer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
            <p class="alert alert-info text-center">Aucune annonce disponible pour le moment.</p>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
