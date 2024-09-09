<?php
session_start();
if (isset($_SESSION['Courriel'])) {
    header("Location: annonces.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Les petites annonces GG</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Bienvenue sur Les petites annonces GG</h1>
    <p><a href="connexion.php">Connexion</a> ou <a href="enregistrement.php">Créer un compte</a></p>
</body>
</html>
