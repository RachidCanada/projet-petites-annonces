CREATE DATABASE petites_annonces;
USE petites_annonces;

CREATE TABLE utilisateurs (
    NoUtilisateur INT AUTO_INCREMENT PRIMARY KEY,
    Courriel VARCHAR(50) UNIQUE NOT NULL,
    MotDePasse VARCHAR(255) NOT NULL,
    Statut INT DEFAULT 0,
    NbConnexions INT DEFAULT 0,
    Nom VARCHAR(25),
    Prenom VARCHAR(20),
    NoTelMaison VARCHAR(15),
    NoTelTravail VARCHAR(21),
    NoTelCellulaire VARCHAR(15),
    Creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Modification TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE annonces (
    NoAnnonce INT AUTO_INCREMENT PRIMARY KEY,
    NoUtilisateur INT,
    Parution TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Categorie INT,
    DescriptionAbregee VARCHAR(50),
    DescriptionComplete VARCHAR(250),
    Prix DECIMAL(10, 2),
    Photo VARCHAR(50),
    Etat INT DEFAULT 1,
    MiseAJour TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (NoUtilisateur) REFERENCES utilisateurs(NoUtilisateur)
);

CREATE TABLE connexions (
    NoConnexion INT AUTO_INCREMENT PRIMARY KEY,
    NoUtilisateur INT,
    Connexion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Deconnexion TIMESTAMP NULL,
    FOREIGN KEY (NoUtilisateur) REFERENCES utilisateurs(NoUtilisateur)
);
