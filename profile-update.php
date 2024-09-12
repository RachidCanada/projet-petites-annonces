<?php
 // Connexion à la base de données
require_once 'db_connexion.php';
// Demarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if(!isset($_SESSION['Courriel'])){
    header("Location: connexion.php");
}

// Récupéer les données du user à partir de la BD
$courriel = $_SESSION['Courriel'];
$sql = " SELECT * FROM utilisateurs WHERE Courriel = ? ";
$stmt = $conn->prepare($sql);
$stmt->execute([$courriel]);

// Récupérer les informations du profil
$profil = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil utilisateur</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/profil.css">
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
    <div class="container mt-5 d-flex flex-column min-vh-100 justify-content-center align-items-center">
        <div class="row w-50">
            <div class="col-md-12">
                <h1 class="text-center my-4">Modifier Profil</h1>
                <form action="traitement_update_profile.php" method="POST">
                    <!-- Nom de famille -->
                    <div class="form-group">
                        <label for="nom">Nom</label>
                        <input type="text"
                            name="nom" 
                            class="form-control" 
                            id="nom" 
                            value="<?php echo $profil['Nom']; ?>"
                        >
                    </div>
                    <!-- Prénom -->
                    <div class="form-group">
                        <label for="prenom">Prenom</label>
                        <input type="text"
                            name="prenom" 
                            class="form-control" 
                            id="prenom" 
                            value="<?php echo $profil['Prenom']; ?>"
                        >
                    </div>
                    <!-- Courriel (non modifiable) -->
                    <div class="form-group">
                        <label for="courriel">Courriel</label>
                        <input type="text"
                            name="courriel" 
                            class="form-control" 
                            id="courriel" 
                            value="<?php echo $profil['Courriel']; ?>"
                            disabled
                        >
                    </div>
                    <!-- Mot de passe -->
                    <div class="form-group">
                        <label class="form-label">Mot de passe</label>
                        <p><a href="modifier_mot_de_passe.php">Modifier le mot de passe</a></p>
                    </div>
                    <!-- Téléphone à la maison (facultatif) -->
                    <div class="form-group">
                        <label for="telephoneMaison" class="form-label">Téléphone à la maison (facultatif)</label>
                        <input type="tel" 
                            class="form-control" 
                            id="telephoneMaison" 
                            name="telephone_maison" 
                            placeholder="Ex: 514-555-5678"
                            value="<?php echo $profil['NoTelMaison']; ?>"
                        >
                        <small class="form-text text-muted">Saisir le numéro de téléphone fixe.</small>
                    </div>
                    <!-- Téléphone au travail (facultatif) -->
                    <div class="form-group">
                        <label for="telephoneTravail" class="form-label">Téléphone au travail (facultatif)</label>
                        <input type="tel" 
                            class="form-control" 
                            id="telephoneTravail" 
                            name="telephone_travail" 
                            placeholder="Ex: 514-555-1234"
                            value="<?php echo $profil['NoTelTravail']; ?>"
                        >
                        <small class="form-text text-muted">Saisir le numéro de téléphone du bureau.</small>
                    </div>
                    <!-- Téléphone cellulaire (facultatif) -->
                    <div class="form-group">
                        <label for="telephoneCellulaire" class="form-label">Téléphone cellulaire (facultatif)</label>
                        <input type="text" 
                            class="form-control" 
                            id="telephoneCellulaire" 
                            name="telephone_cellulaire" 
                            placeholder="Ex: 514-555-6789"
                            value="<?php echo $profil['NoTelCellulaire']; ?>"
                        >
                        <small class="form-text text-muted">Saisir le numéro de téléphone mobile.</small>
                    </div>
                    <!-- Bouton de soumission -->
                    <button type="submit" class="btn btn-primary">Mettre à jour le profil</button>
                </form>
            </div>
        </div>

    </div>
</body>