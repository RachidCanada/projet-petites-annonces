<?php
session_start();
require 'db_connexion.php';

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
    <link rel="stylesheet" href="styles.css">
</head>
<body>
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
</body>
</html>
