<?php
// Connexion à la base de données
require_once 'db_connexion.php';
// Demarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if(!isset($_SESSION['Courriel'])){
    header("Location: connexion.php");
}

// Récupérer les annonces de l'utilisateur connecté
$stmt = $conn->prepare("SELECT NoAnnonce, DescriptionAbregee, Etat FROM annonces WHERE NoUtilisateur = :noUtilisateur");
$stmt->bindParam(':noUtilisateur', $_SESSION['NoUtilisateur']);
$stmt->execute();
$annonces = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des annonces - Petites annonces GG</title>
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
            <?php if(isset($_SESSION['Courriel'])){echo '<li><a href="profile.php">Mon profil</a></li>';}?>
            <?php if(isset($_SESSION['Courriel'])){echo '<li><a href="deconnexion.php">Déconnexion</a></li>';} ?>
            <?php if(!isset($_SESSION['Courriel'])){echo '<li><a href="connexion.php">login</a></li>';}?>
            <?php if(!isset($_SESSION['Courriel'])){echo '<li><a href="enregistrement.php">s\'inscrire</a></li>';}?>
        </ul>
    </nav>
    <div class="container">
        <h1>Gérer mes annonces</h1>
        <table>
            <tr>
                <th>Description</th>
                <th>État</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($annonces as $annonce): ?>
            <tr>
                <td><?php echo $annonce['DescriptionAbregee']; ?></td>
                <td><?php echo ($annonce['Etat'] == 1) ? 'Actif' : 'Inactif'; ?></td>
                <td>
                    <a href="modifier_annonce.php?no=<?php echo $annonce['NoAnnonce']; ?>">Modifier</a> |
                    <a href="retirer_annonce.php?no=<?php echo $annonce['NoAnnonce']; ?>">Retirer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
            </div>
</body>
</html>
