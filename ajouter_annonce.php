<?php
session_start();
require 'db_connexion.php'; // Connexion à la base de données

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une annonce</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="my-4 text-center">Ajouter une annonce</h1>
        <form action="traitement_ajouter_annonce.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="descriptionAbregee">Description abrégée</label>
                <input type="text" class="form-control" id="descriptionAbregee" name="descriptionAbregee" required>
            </div>
            <div class="form-group">
                <label for="descriptionComplete">Description complète</label>
                <textarea class="form-control" id="descriptionComplete" name="descriptionComplete" rows="5" required></textarea>
            </div>
            <div class="form-group">
                <label for="prix">Prix</label>
                <input type="number" class="form-control" id="prix" name="prix" required>
            </div>
            <div class="form-group">
                <label for="photo">Photo</label>
                <input type="file" class="form-control-file" id="photo" name="photo" required>
            </div>
            <button type="submit" class="btn btn-primary">Ajouter l'annonce</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
