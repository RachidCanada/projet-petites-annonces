<?php
session_start();
require 'db_connexion.php'; // Connexion à la base de données

$erreur = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $courriel = trim($_POST['courriel']);
    $motDePasse = trim($_POST['motDePasse']);

    if (!empty($courriel) && !empty($motDePasse)) {
        // Préparer la requête pour éviter les injections SQL
        $stmt = $conn->prepare("SELECT * FROM utilisateurs WHERE Courriel = :courriel");
        $stmt->bindParam(':courriel', $courriel);
        $stmt->execute();
        $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($utilisateur && password_verify($motDePasse, $utilisateur['MotDePasse'])) {
            // Le mot de passe est correct, connexion réussie
            $_SESSION['Courriel'] = $courriel;
            $_SESSION['Nom'] = $utilisateur['Nom'];
            header("Location: annonces.php"); // Rediriger vers la page des annonces
            exit();
        } else {
            $erreur = "Courriel ou mot de passe incorrect.";
        }
    } else {
        $erreur = "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - Petites annonces GG</title>
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
            <?php if(!isset($_SESSION['Courriel'])){echo '<li><a href="connexion.php">Login</a></li>';}?>
            <?php if(!isset($_SESSION['Courriel'])){echo '<li><a href="enregistrement.php">Inscrire</a></li>';}?>
        </ul>
    </nav>
    <div class="container">
        <h1>Connexion</h1>
        <?php if ($erreur): ?>
            <p style="color:red;"><?php echo $erreur; ?></p>
        <?php endif; ?>
        <form method="POST" action="connexion.php">
            <label for="courriel">Courriel :</label>
            <input type="email" name="courriel" required>
            <br><br>
            <label for="motDePasse">Mot de passe :</label>
            <input type="password" name="motDePasse" required>
            <br><br>
            <input type="submit" value="Se connecter">
        </form>
        <p><a href="enregistrement.php">Créer un compte</a></p>
    </div>
    
</body>
</html> 
