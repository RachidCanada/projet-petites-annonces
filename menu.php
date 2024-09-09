<?php
session_start();
if (!isset($_SESSION['Courriel'])) {
    header("Location: index.php"); // Redirection si l'utilisateur n'est pas connecté
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Menu principal - Petites annonces GG</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Bienvenue <?php echo $_SESSION['Nom']; ?> !</h1>
    <ul>
        <li><a href="annonces.php">Afficher les annonces</a></li>
        <li><a href="gerer_annonces.php">Gérer mes annonces</a></li>
        <li><a href="profil.php">Modifier mon profil</a></li>
        <li><a href="deconnexion.php">Déconnexion</a></li>
    </ul>
</body>
</html>
