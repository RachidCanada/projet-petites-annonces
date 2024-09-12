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
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="text-center">
        <h1>Bienvenue sur les petites annonces GG</h1>
        <p><a href="connexion.php">Connexion</a> ou <a href="enregistrement.php">Créer un compte</a></p>
    </div>
    
</body>
</html>
