<?php 
    // Connexion à la base de données
    require_once 'db_connexion.php';
    // Demarrer la session
    session_start();

    // Vérifier si l'utilisateur est connecté
    if(!isset($_SESSION['Courriel'])){
        header("Location: connexion.php");
    }
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
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="profile-header">
                    <?php 
                        // Vérifier si l'utilisateur est connecté et a une session active
                        if(isset($_SESSION['Courriel'])){
                            // Récupérer l'e-mail de l'utilisateur à partir de la session
                            $courriel = $_SESSION['Courriel'];
                            try {
                                // Prepare sql Query to get user data from database
                                $sql = "SELECT * FROM utilisateurs WHERE Courriel = :courriel";
                                $stmt = $conn->prepare($sql);
                                // Bind the email value as a string explicitly
                                $stmt->bindParam(':courriel', $courriel, PDO::PARAM_STR);
                                $stmt->execute();

                                // Récupérer les informations du profil
                                $profil = $stmt->fetch(PDO::FETCH_ASSOC);

                                // verifier si le profil existe
                                if($profil){
                                    echo '<div>';
                                    // Afficher la photo de profil si elle existe
                                    if (!empty($profil['photo'])) {
                                        echo '<img class="mb-2"src="data:image/jpeg;base64,' . base64_encode($profil['photo']) . '" alt="Profile Picture">';
                                    } else {
                                        // Afficher l'image par défaut si aucune photo n'est trouvée
                                        echo '<img class="mb-2" src="photos-annonce/user-profile-icon2.webp" alt="Profile Picture">';
                                    }
                                    echo '</div>';

                                    // Safely handle and display profile data
                                    $nom = isset($profil['Nom']) ? htmlspecialchars($profil['Nom']) : 'non disponible';
                                    $prenom = isset($profil['Prenom']) ? htmlspecialchars($profil['Prenom']) : 'non disponible';
                                    $email = isset($profil['Courriel']) ? htmlspecialchars($profil['Courriel']) : 'non disponible';
                                    $telephone = isset($profil['NoTelCellulaire']) ? htmlspecialchars($profil['NoTelCellulaire']) : 'non disponible';

                                    // display data
                                    echo '<p>' . $email . '</p>';
                                    echo '<div class="mt-4">';
                                    echo '<p>Nom: ' . $nom . '</p>';
                                    echo '<p>Prénom: ' . $prenom . '</p>';
                                    echo '<p>Téléphone: ' . $telephone . '</p>';
                                    echo '<div>'; 
                                }else{
                                    $erreur = "Utilisateur introuvable.";
                                }

                            }catch(PDOException $e){
                                // Display the SQL error message
                                echo "Erreur SQL: " . $e->getMessage();
                            }

                        }else{
                            $erreur = "Session utilisateur inactive.";
                        }
                    ?>

                    <form action="profile-update.php" method="post"> <!-- Assurez-vous de créer un fichier modifier_profil.php pour gérer la modification du profil -->
                        <button type="submit" name="modifier" value="Modifier" class="btn btn-info btn-change-photo"><b>Modifier le profil</b></button>
                    </form>
                </div>
            </div>
        </div>
    </div>   
</body>
</html>