<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230411164346 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE abonnement (id INT AUTO_INCREMENT NOT NULL, useridfollowed_id INT DEFAULT NULL, userid_id INT DEFAULT NULL, INDEX IDX_351268BBC5009E14 (useridfollowed_id), INDEX IDX_351268BB58E0A285 (userid_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE administrateur (pseudo VARCHAR(255) NOT NULL, iduser_id INT DEFAULT NULL, INDEX IDX_32EB52E8786A81FB (iduser_id), PRIMARY KEY(pseudo)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE avis (id VARCHAR(255) NOT NULL, idproduit_id INT DEFAULT NULL, idevaluateuruser_id INT DEFAULT NULL, description VARCHAR(100) NOT NULL, note VARCHAR(255) NOT NULL, date DATE NOT NULL, INDEX IDX_8F91ABF0C29D63C1 (idproduit_id), INDEX IDX_8F91ABF0D6AF2D81 (idevaluateuruser_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE badge (idbadge INT AUTO_INCREMENT NOT NULL, userid_id INT DEFAULT NULL, testid_id INT DEFAULT NULL, nombadge VARCHAR(255) NOT NULL, date DATETIME NOT NULL, INDEX IDX_FEF0481D58E0A285 (userid_id), INDEX IDX_FEF0481D2718C483 (testid_id), PRIMARY KEY(idbadge)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE candidat (idcandidat VARCHAR(255) NOT NULL, iduser_id INT DEFAULT NULL, secteur VARCHAR(255) NOT NULL, INDEX IDX_6AB5B471786A81FB (iduser_id), PRIMARY KEY(idcandidat)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (id_commande VARCHAR(255) NOT NULL, produit_id INT DEFAULT NULL, acheteur_id INT DEFAULT NULL, vendeur_id INT DEFAULT NULL, dateCommande DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, montantPaye NUMERIC(10, 2) NOT NULL, INDEX IDX_6EEAA67DF347EFB (produit_id), INDEX IDX_6EEAA67D96A7BB5F (acheteur_id), INDEX IDX_6EEAA67D858C065E (vendeur_id), PRIMARY KEY(id_commande)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, idpub_id INT DEFAULT NULL, iduser_id INT DEFAULT NULL, commentaire VARCHAR(100) NOT NULL, INDEX IDX_67F068BCE7404DDB (idpub_id), INDEX IDX_67F068BC786A81FB (iduser_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE competence (libelle VARCHAR(255) NOT NULL, userid_id INT DEFAULT NULL, INDEX IDX_94D4687F58E0A285 (userid_id), PRIMARY KEY(libelle)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cv (idcv INT AUTO_INCREMENT NOT NULL, userid_id INT DEFAULT NULL, cin INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, sexe VARCHAR(10) NOT NULL, datenaissance DATETIME NOT NULL, photo VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, langue VARCHAR(255) NOT NULL, education VARCHAR(255) NOT NULL, INDEX IDX_B66FFE9258E0A285 (userid_id), PRIMARY KEY(idcv)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employeur (idemployeur VARCHAR(255) NOT NULL, iduser_id INT DEFAULT NULL, companyName VARCHAR(255) NOT NULL, secteur VARCHAR(255) NOT NULL, INDEX IDX_8747E1C7786A81FB (iduser_id), PRIMARY KEY(idemployeur)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, proprietaire_id INT DEFAULT NULL, titre VARCHAR(30) NOT NULL, sujet VARCHAR(100) NOT NULL, lieu VARCHAR(50) NOT NULL, horaire VARCHAR(10) NOT NULL, dateevent VARCHAR(255) NOT NULL, INDEX IDX_B26681E76C50E4A (proprietaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE experience (userid_id INT DEFAULT NULL, idExperience INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, type VARCHAR(50) NOT NULL, lieu VARCHAR(50) DEFAULT NULL, secteur VARCHAR(255) DEFAULT NULL, dateDebut DATE DEFAULT NULL, dateFin DATE DEFAULT NULL, INDEX IDX_590C10358E0A285 (userid_id), PRIMARY KEY(idExperience)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE maillist (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offre (id INT AUTO_INCREMENT NOT NULL, proprietaire INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, typeOffre VARCHAR(50) NOT NULL, description TEXT NOT NULL, dateDebut DATE NOT NULL, dateFin DATE DEFAULT NULL, competence TEXT NOT NULL, idSecteur INT DEFAULT NULL, INDEX proprietaire (proprietaire), INDEX offre_ibfk_21 (idSecteur), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participants (idparticipant INT AUTO_INCREMENT NOT NULL, idevent_id INT DEFAULT NULL, iduser_id INT DEFAULT NULL, INDEX IDX_71697092DB22A086 (idevent_id), INDEX IDX_71697092786A81FB (iduser_id), PRIMARY KEY(idparticipant)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE postulation (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, vendeur_id INT DEFAULT NULL, categorie VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, description TEXT NOT NULL, image VARCHAR(255) NOT NULL, prix NUMERIC(10, 2) NOT NULL, date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, INDEX IDX_29A5EC27858C065E (vendeur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE publication (id INT AUTO_INCREMENT NOT NULL, proprietaire_id INT DEFAULT NULL, libelle VARCHAR(30) NOT NULL, datepub VARCHAR(255) NOT NULL, description VARCHAR(100) NOT NULL, cat VARCHAR(30) NOT NULL, INDEX IDX_AF3C677976C50E4A (proprietaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reclamation (id VARCHAR(255) NOT NULL, id_avis_id VARCHAR(255) DEFAULT NULL, nom VARCHAR(10) NOT NULL, prenom VARCHAR(10) NOT NULL, description VARCHAR(255) NOT NULL, sujetdereclamations VARCHAR(255) NOT NULL, email VARCHAR(150) NOT NULL, tel VARCHAR(100) NOT NULL, etat VARCHAR(255) NOT NULL, INDEX IDX_CE606404C7E3D9EF (id_avis_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE secteur (IdSecteur INT AUTO_INCREMENT NOT NULL, nom VARCHAR(25) NOT NULL, description TEXT NOT NULL, DateCreation DATE NOT NULL, DateModification DATE DEFAULT NULL, PRIMARY KEY(IdSecteur)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, Prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, motDePasse VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, bio TEXT DEFAULT NULL, photoPath VARCHAR(255) DEFAULT NULL, numTel VARCHAR(255) DEFAULT NULL, UNIQUE INDEX email (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE abonnement ADD CONSTRAINT FK_351268BBC5009E14 FOREIGN KEY (useridfollowed_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE abonnement ADD CONSTRAINT FK_351268BB58E0A285 FOREIGN KEY (userid_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE administrateur ADD CONSTRAINT FK_32EB52E8786A81FB FOREIGN KEY (iduser_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0C29D63C1 FOREIGN KEY (idproduit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0D6AF2D81 FOREIGN KEY (idevaluateuruser_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE badge ADD CONSTRAINT FK_FEF0481D58E0A285 FOREIGN KEY (userid_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE badge ADD CONSTRAINT FK_FEF0481D2718C483 FOREIGN KEY (testid_id) REFERENCES test (id)');
        $this->addSql('ALTER TABLE candidat ADD CONSTRAINT FK_6AB5B471786A81FB FOREIGN KEY (iduser_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D96A7BB5F FOREIGN KEY (acheteur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D858C065E FOREIGN KEY (vendeur_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCE7404DDB FOREIGN KEY (idpub_id) REFERENCES publication (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC786A81FB FOREIGN KEY (iduser_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE competence ADD CONSTRAINT FK_94D4687F58E0A285 FOREIGN KEY (userid_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE cv ADD CONSTRAINT FK_B66FFE9258E0A285 FOREIGN KEY (userid_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE employeur ADD CONSTRAINT FK_8747E1C7786A81FB FOREIGN KEY (iduser_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E76C50E4A FOREIGN KEY (proprietaire_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE experience ADD CONSTRAINT FK_590C10358E0A285 FOREIGN KEY (userid_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866F90FC4EED FOREIGN KEY (idSecteur) REFERENCES secteur (IdSecteur)');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866F69E399D6 FOREIGN KEY (proprietaire) REFERENCES user (id)');
        $this->addSql('ALTER TABLE participants ADD CONSTRAINT FK_71697092DB22A086 FOREIGN KEY (idevent_id) REFERENCES evenement (id)');
        $this->addSql('ALTER TABLE participants ADD CONSTRAINT FK_71697092786A81FB FOREIGN KEY (iduser_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27858C065E FOREIGN KEY (vendeur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C677976C50E4A FOREIGN KEY (proprietaire_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404C7E3D9EF FOREIGN KEY (id_avis_id) REFERENCES avis (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE abonnement DROP FOREIGN KEY FK_351268BBC5009E14');
        $this->addSql('ALTER TABLE abonnement DROP FOREIGN KEY FK_351268BB58E0A285');
        $this->addSql('ALTER TABLE administrateur DROP FOREIGN KEY FK_32EB52E8786A81FB');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF0C29D63C1');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF0D6AF2D81');
        $this->addSql('ALTER TABLE badge DROP FOREIGN KEY FK_FEF0481D58E0A285');
        $this->addSql('ALTER TABLE badge DROP FOREIGN KEY FK_FEF0481D2718C483');
        $this->addSql('ALTER TABLE candidat DROP FOREIGN KEY FK_6AB5B471786A81FB');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DF347EFB');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D96A7BB5F');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D858C065E');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCE7404DDB');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC786A81FB');
        $this->addSql('ALTER TABLE competence DROP FOREIGN KEY FK_94D4687F58E0A285');
        $this->addSql('ALTER TABLE cv DROP FOREIGN KEY FK_B66FFE9258E0A285');
        $this->addSql('ALTER TABLE employeur DROP FOREIGN KEY FK_8747E1C7786A81FB');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E76C50E4A');
        $this->addSql('ALTER TABLE experience DROP FOREIGN KEY FK_590C10358E0A285');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866F90FC4EED');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866F69E399D6');
        $this->addSql('ALTER TABLE participants DROP FOREIGN KEY FK_71697092DB22A086');
        $this->addSql('ALTER TABLE participants DROP FOREIGN KEY FK_71697092786A81FB');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27858C065E');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C677976C50E4A');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404C7E3D9EF');
        $this->addSql('DROP TABLE abonnement');
        $this->addSql('DROP TABLE administrateur');
        $this->addSql('DROP TABLE avis');
        $this->addSql('DROP TABLE badge');
        $this->addSql('DROP TABLE candidat');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE competence');
        $this->addSql('DROP TABLE cv');
        $this->addSql('DROP TABLE employeur');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE experience');
        $this->addSql('DROP TABLE maillist');
        $this->addSql('DROP TABLE offre');
        $this->addSql('DROP TABLE participants');
        $this->addSql('DROP TABLE postulation');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE publication');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE secteur');
        $this->addSql('DROP TABLE user');
    }
}
