-- =====================================================================
--  Base de données : bibliotheque
--  Schéma reconstruit à partir des requêtes SQL présentes dans le code PHP
--  (noms de tables/colonnes strictement identiques à ceux utilisés).
--  Import : phpMyAdmin > Importer, ou  mysql -u root < database/bibliotheque.sql
-- =====================================================================

CREATE DATABASE IF NOT EXISTS `bibliotheque`
  CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `bibliotheque`;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS `amende`, `relance`, `reservation`, `emprunt`, `exemplaire`,
                     `realiser_par`, `livre`, `periodique`, `document`, `auteur`,
                     `editeur`, `bibliothecaire`, `utilisateur`, `admin`;
SET FOREIGN_KEY_CHECKS = 1;

-- ---------------------------------------------------------------------
--  Comptes
-- ---------------------------------------------------------------------
-- Directeur (connexion : auth/connexion-directeur.php)
CREATE TABLE `admin` (
  `id_admin`     INT AUTO_INCREMENT PRIMARY KEY,
  `nom-prenom`   VARCHAR(100) NOT NULL,
  `mot-de-passe` VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

-- Bibliothécaires : categorie = 'principal' ou 'stagiaire'
CREATE TABLE `bibliothecaire` (
  `id_bibliothecaire` INT AUTO_INCREMENT PRIMARY KEY,
  `nom_prenom`  VARCHAR(100) NOT NULL,
  `email`       VARCHAR(100),
  `telephone`   VARCHAR(20),
  `categorie`   VARCHAR(20) NOT NULL DEFAULT 'stagiaire',
  `date_debut`  DATE,
  `date_fin`    DATE NULL,
  `password`    VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

-- Lecteurs : type_utilisateur = occasionnel | abonné | abonné_privilégié
--            statut           = actif | suspendu
CREATE TABLE `utilisateur` (
  `id_utilisateur`   INT AUTO_INCREMENT PRIMARY KEY,
  `nom`              VARCHAR(50) NOT NULL,
  `prenom`           VARCHAR(50) NOT NULL,
  `email`            VARCHAR(100),
  `telephone`        VARCHAR(20),
  `type_utilisateur` VARCHAR(30) NOT NULL DEFAULT 'occasionnel',
  `statut`           VARCHAR(20) NOT NULL DEFAULT 'actif',
  `date_inscription` DATE,
  `mot de passe`     VARCHAR(255)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
--  Catalogue
-- ---------------------------------------------------------------------
CREATE TABLE `editeur` (
  `id_editeur` INT AUTO_INCREMENT PRIMARY KEY,
  `nom`        VARCHAR(100) NOT NULL,
  `prenom`     VARCHAR(100)
) ENGINE=InnoDB;

CREATE TABLE `auteur` (
  `id_auteur` INT AUTO_INCREMENT PRIMARY KEY,
  `nom`       VARCHAR(100) NOT NULL,
  `prenom`    VARCHAR(100)
) ENGINE=InnoDB;

-- type_document = 'livre' | 'periodique'
CREATE TABLE `document` (
  `id_document`       INT AUTO_INCREMENT PRIMARY KEY,
  `titre`             VARCHAR(255) NOT NULL,
  `annee_publication` INT,
  `type_document`     VARCHAR(20) NOT NULL,
  `reference`         VARCHAR(50),
  `id_editeur`        INT NULL,
  CONSTRAINT `fk_document_editeur` FOREIGN KEY (`id_editeur`)
    REFERENCES `editeur`(`id_editeur`) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE `livre` (
  `code_isbn`   VARCHAR(20) PRIMARY KEY,
  `id_document` INT NOT NULL,
  CONSTRAINT `fk_livre_document` FOREIGN KEY (`id_document`)
    REFERENCES `document`(`id_document`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `periodique` (
  `code_issn`   VARCHAR(20) PRIMARY KEY,
  `id_document` INT NOT NULL,
  CONSTRAINT `fk_periodique_document` FOREIGN KEY (`id_document`)
    REFERENCES `document`(`id_document`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `realiser_par` (
  `code_isbn` VARCHAR(20) NOT NULL,
  `id_auteur` INT NOT NULL,
  PRIMARY KEY (`code_isbn`, `id_auteur`),
  CONSTRAINT `fk_rp_livre`  FOREIGN KEY (`code_isbn`) REFERENCES `livre`(`code_isbn`)   ON DELETE CASCADE,
  CONSTRAINT `fk_rp_auteur` FOREIGN KEY (`id_auteur`) REFERENCES `auteur`(`id_auteur`)  ON DELETE CASCADE
) ENGINE=InnoDB;

-- etat   = neuf | bon | usagé | endommagé | détruit
-- statut = en_rayon | en_pret | en_reserve | en_travaux
CREATE TABLE `exemplaire` (
  `id_exemplaire` INT AUTO_INCREMENT PRIMARY KEY,
  `numero_ordre`  INT NOT NULL,
  `date_achat`    DATE,
  `etat`          VARCHAR(20) NOT NULL DEFAULT 'neuf',
  `statut`        VARCHAR(20) NOT NULL DEFAULT 'en_rayon',
  `id_document`   INT NOT NULL,
  CONSTRAINT `fk_exemplaire_document` FOREIGN KEY (`id_document`)
    REFERENCES `document`(`id_document`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
--  Activité
-- ---------------------------------------------------------------------
-- statut (valeurs utilisées par le code) : en_cours | prolongé | retourné | en_retard
CREATE TABLE `emprunt` (
  `id_emprunt`     INT AUTO_INCREMENT PRIMARY KEY,
  `id_exemplaire`  INT NOT NULL,
  `id_utilisateur` INT NOT NULL,
  `date_debut`     DATE NOT NULL,
  `date_fin`       DATE NOT NULL,
  `statut`         VARCHAR(20) NOT NULL DEFAULT 'en_cours',
  CONSTRAINT `fk_emprunt_exemplaire`  FOREIGN KEY (`id_exemplaire`)  REFERENCES `exemplaire`(`id_exemplaire`)   ON DELETE CASCADE,
  CONSTRAINT `fk_emprunt_utilisateur` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur`(`id_utilisateur`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `reservation` (
  `id_reservation`   INT AUTO_INCREMENT PRIMARY KEY,
  `id_exemplaire`    INT NOT NULL,
  `id_utilisateur`   INT NOT NULL,
  `date_reservation` DATE NOT NULL,
  CONSTRAINT `fk_reservation_exemplaire`  FOREIGN KEY (`id_exemplaire`)  REFERENCES `exemplaire`(`id_exemplaire`)   ON DELETE CASCADE,
  CONSTRAINT `fk_reservation_utilisateur` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur`(`id_utilisateur`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `relance` (
  `id_relance`   INT AUTO_INCREMENT PRIMARY KEY,
  `id_emprunt`   INT NOT NULL,
  `date_relance` DATETIME NOT NULL,
  `message`      TEXT,
  CONSTRAINT `fk_relance_emprunt` FOREIGN KEY (`id_emprunt`)
    REFERENCES `emprunt`(`id_emprunt`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- statut = non_payee | payee
CREATE TABLE `amende` (
  `id_amende`     INT AUTO_INCREMENT PRIMARY KEY,
  `id_emprunt`    INT NOT NULL,
  `montant`       DECIMAL(8,2) NOT NULL,
  `statut`        VARCHAR(20) NOT NULL DEFAULT 'non_payee',
  `date_paiement` DATETIME NULL,
  CONSTRAINT `fk_amende_emprunt` FOREIGN KEY (`id_emprunt`)
    REFERENCES `emprunt`(`id_emprunt`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =====================================================================
--  DONNÉES DE DÉMONSTRATION  (à supprimer en production)
--  Mots de passe en clair car le code actuel les compare en clair.
-- =====================================================================
INSERT INTO `admin` (`nom-prenom`, `mot-de-passe`) VALUES ('Directeur Demo', 'admin1234');

INSERT INTO `bibliothecaire` (`nom_prenom`, `email`, `telephone`, `categorie`, `date_debut`, `password`) VALUES
  ('Principal Demo', 'principal@demo.local', '0600000001', 'principal', '2024-01-01', 'demo1234'),
  ('Stagiaire Demo', 'stagiaire@demo.local', '0600000002', 'stagiaire', '2024-09-01', 'demo1234');

INSERT INTO `utilisateur` (`nom`, `prenom`, `email`, `type_utilisateur`, `statut`, `date_inscription`, `mot de passe`) VALUES
  ('Demo', 'Utilisateur', 'user@demo.local', 'abonné', 'actif', '2024-10-01', 'user1234');

INSERT INTO `editeur` (`nom`, `prenom`) VALUES ('Gallimard', 'Editions'), ('Larousse', 'Editions');
INSERT INTO `auteur`  (`nom`, `prenom`) VALUES ('Hugo', 'Victor');

INSERT INTO `document` (`titre`, `annee_publication`, `type_document`, `reference`, `id_editeur`) VALUES
  ('Les Misérables', 1862, 'livre',      'REF-001', 1),
  ('Science & Vie',  2024, 'periodique', 'REF-002', 2);

INSERT INTO `livre`      (`code_isbn`, `id_document`) VALUES ('9782070409228', 1);
INSERT INTO `periodique` (`code_issn`, `id_document`) VALUES ('0036-8369', 2);
INSERT INTO `realiser_par` (`code_isbn`, `id_auteur`) VALUES ('9782070409228', 1);

INSERT INTO `exemplaire` (`numero_ordre`, `date_achat`, `etat`, `statut`, `id_document`) VALUES
  (1, '2024-01-15', 'neuf', 'en_rayon', 1),
  (2, '2024-01-15', 'bon',  'en_rayon', 1),
  (1, '2024-06-01', 'neuf', 'en_rayon', 2);
