<?php
require 'db_connexion.php';
$erreur = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $courriel = $_POST['courriel'];
    $motDePasse = $_POST['motDePasse'];
    $motDePasseConfirm = $_POST['motDePasseConfirm'];

    if ($motDePasse !== $motDePasseConfirm) {
        $erreur = 'Les mots de passe ne correspondent pas.';
    } else {
        $hashMotDePasse = password_hash($motDePasse, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("INSERT INTO utilisateurs (Courriel, MotDePasse, Statut) VALUES (?, ?, 0)");
        if ($stmt->execute([$courriel, $hashMotDePasse])) {
            echo "Enregistrement réussi ! Un email de confirmation vous sera envoyé.";
        } else {
            $erreur = "Erreur lors de l'enregistrement.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription - Petites annonces GG</title>
</head>
<body>
    <h1>Créer un compte</h1>
    <form method="POST" action="enregistrement.php">
        <label for="courriel">Courriel :</label>
        <input type="email" name="courriel" required>
        <label for="motDePasse">Mot de passe :</label>
        <input type="password" name="motDePasse" required>
        <label for="motDePasseConfirm">Confirmer le mot de passe :</label>
        <input type="password" name="motDePasseConfirm" required>
        <input type="submit" value="S'inscrire">
    </form>
</body>
</html>
