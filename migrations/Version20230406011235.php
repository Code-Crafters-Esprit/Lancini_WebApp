<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230406011235 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE abonnement (userid INT DEFAULT NULL, idAbonnement INT AUTO_INCREMENT NOT NULL, useridFollowed INT DEFAULT NULL, INDEX IDX_351268BBF132696E (userid), INDEX IDX_351268BB53DDBAB5 (useridFollowed), PRIMARY KEY(idAbonnement)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE administrateur (pseudo VARCHAR(255) NOT NULL, idUser INT DEFAULT NULL, INDEX IDX_32EB52E8FE6E88D7 (idUser), PRIMARY KEY(pseudo)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE avis (id_avis VARCHAR(255) NOT NULL, description VARCHAR(100) NOT NULL, note VARCHAR(255) NOT NULL, date DATE NOT NULL, idProduit INT DEFAULT NULL, idEvaluateurUser INT DEFAULT NULL, INDEX IDX_8F91ABF0391C87D5 (idProduit), INDEX IDX_8F91ABF088055874 (idEvaluateurUser), PRIMARY KEY(id_avis)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE badge (idBadge INT AUTO_INCREMENT NOT NULL, nombadge VARCHAR(255) NOT NULL, date DATETIME NOT NULL, userId INT DEFAULT NULL, testId INT DEFAULT NULL, INDEX IDX_FEF0481D64B64DCC (userId), INDEX IDX_FEF0481D31B588BA (testId), PRIMARY KEY(idBadge)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE candidat (idcandidat VARCHAR(255) NOT NULL, secteur VARCHAR(255) NOT NULL, idUser INT DEFAULT NULL, INDEX IDX_6AB5B471FE6E88D7 (idUser), PRIMARY KEY(idcandidat)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (id_commande VARCHAR(255) NOT NULL, produit INT DEFAULT NULL, acheteur INT DEFAULT NULL, vendeur INT DEFAULT NULL, dateCommande DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, montantPaye NUMERIC(10, 2) NOT NULL, INDEX IDX_6EEAA67D29A5EC27 (produit), INDEX IDX_6EEAA67D304AFF9D (acheteur), INDEX IDX_6EEAA67D7AF49996 (vendeur), PRIMARY KEY(id_commande)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (idcomm INT AUTO_INCREMENT NOT NULL, commentaire VARCHAR(100) NOT NULL, idPub INT DEFAULT NULL, idUser INT DEFAULT NULL, INDEX IDX_67F068BC7B0C2102 (idPub), INDEX IDX_67F068BCFE6E88D7 (idUser), PRIMARY KEY(idcomm)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE competence (libelle VARCHAR(255) NOT NULL, userId INT DEFAULT NULL, INDEX IDX_94D4687F64B64DCC (userId), PRIMARY KEY(libelle)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cv (idcv INT AUTO_INCREMENT NOT NULL, cin INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, sexe VARCHAR(10) NOT NULL, datenaissance DATETIME NOT NULL, photo VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, langue VARCHAR(255) NOT NULL, education VARCHAR(255) NOT NULL, userId INT DEFAULT NULL, INDEX IDX_B66FFE9264B64DCC (userId), PRIMARY KEY(idcv)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employeur (idemployeur VARCHAR(255) NOT NULL, companyName VARCHAR(255) NOT NULL, secteur VARCHAR(255) NOT NULL, idUser INT DEFAULT NULL, INDEX IDX_8747E1C7FE6E88D7 (idUser), PRIMARY KEY(idemployeur)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement (proprietaire INT DEFAULT NULL, idEvent INT AUTO_INCREMENT NOT NULL, titre VARCHAR(30) NOT NULL, sujet VARCHAR(100) NOT NULL, lieu VARCHAR(50) NOT NULL, horaire VARCHAR(10) NOT NULL, dateevent VARCHAR(255) NOT NULL, INDEX IDX_B26681E69E399D6 (proprietaire), PRIMARY KEY(idEvent)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE experience (idExperience INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, type VARCHAR(50) NOT NULL, lieu VARCHAR(50) DEFAULT NULL, secteur VARCHAR(255) DEFAULT NULL, dateDebut DATE DEFAULT NULL, dateFin DATE DEFAULT NULL, userId INT DEFAULT NULL, INDEX IDX_590C10364B64DCC (userId), PRIMARY KEY(idExperience)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE maillist (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offre (proprietaire INT DEFAULT NULL, idOffre INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, typeOffre VARCHAR(50) NOT NULL, description LONGTEXT NOT NULL, dateDebut DATE NOT NULL, dateFin DATE DEFAULT NULL, competence LONGTEXT NOT NULL, idSecteur INT DEFAULT NULL, INDEX IDX_AF86866F69E399D6 (proprietaire), INDEX IDX_AF86866F90FC4EED (idSecteur), PRIMARY KEY(idOffre)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participants (idparticipant INT AUTO_INCREMENT NOT NULL, idEvent INT DEFAULT NULL, idUser INT DEFAULT NULL, INDEX IDX_716970922C6A49BA (idEvent), INDEX IDX_71697092FE6E88D7 (idUser), PRIMARY KEY(idparticipant)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE postulation (idPost INT AUTO_INCREMENT NOT NULL, idOffre INT DEFAULT NULL, idUser INT DEFAULT NULL, INDEX IDX_DA7D4E9BB842C572 (idOffre), INDEX IDX_DA7D4E9BFE6E88D7 (idUser), PRIMARY KEY(idPost)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (vendeur INT DEFAULT NULL, idProduit INT AUTO_INCREMENT NOT NULL, categorie VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, description TEXT NOT NULL, image VARCHAR(255) NOT NULL, prix NUMERIC(10, 2) DEFAULT NULL, date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, INDEX IDX_29A5EC277AF49996 (vendeur), PRIMARY KEY(idProduit)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE publication (proprietaire INT DEFAULT NULL, idPub INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(30) NOT NULL, datepub VARCHAR(255) NOT NULL, description VARCHAR(100) NOT NULL, cat VARCHAR(30) NOT NULL, INDEX IDX_AF3C677969E399D6 (proprietaire), PRIMARY KEY(idPub)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, testId INT DEFAULT NULL, INDEX IDX_B6F7494E31B588BA (testId), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quiz (idquiz INT AUTO_INCREMENT NOT NULL, question VARCHAR(255) NOT NULL, reponsecorrecte VARCHAR(255) NOT NULL, reponsefausse1 VARCHAR(255) NOT NULL, reponsefausse2 VARCHAR(255) NOT NULL, reponsefausse3 VARCHAR(255) NOT NULL, idTest INT DEFAULT NULL, INDEX IDX_A412FA92AB822092 (idTest), PRIMARY KEY(idquiz)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reclamation (id VARCHAR(255) NOT NULL, nom VARCHAR(10) NOT NULL, prenom VARCHAR(10) NOT NULL, description VARCHAR(255) NOT NULL, sujetdereclamations VARCHAR(255) NOT NULL, email VARCHAR(150) NOT NULL, tel VARCHAR(100) NOT NULL, etat VARCHAR(255) NOT NULL, idAvis VARCHAR(255) DEFAULT NULL, INDEX IDX_CE606404FC6CF56E (idAvis), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponse (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) DEFAULT NULL, estvrai TINYINT(1) DEFAULT NULL, questionId INT DEFAULT NULL, INDEX IDX_5FB6DEC74B476EBA (questionId), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE secteur (IdSecteur INT AUTO_INCREMENT NOT NULL, nom VARCHAR(25) NOT NULL, description TEXT NOT NULL, DateCreation DATE NOT NULL, DateModification DATE DEFAULT NULL, PRIMARY KEY(IdSecteur)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE test (idTest INT AUTO_INCREMENT NOT NULL, nomtest VARCHAR(255) NOT NULL, difficulte INT NOT NULL, PRIMARY KEY(idTest)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (idUser INT AUTO_INCREMENT NOT NULL, Nom VARCHAR(255) NOT NULL, Prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, motDePasse VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, bio VARCHAR(65535) NOT NULL, photoPath VARCHAR(255) NOT NULL, numTel VARCHAR(255) NOT NULL, PRIMARY KEY(idUser)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE abonnement ADD CONSTRAINT FK_351268BBF132696E FOREIGN KEY (userid) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE abonnement ADD CONSTRAINT FK_351268BB53DDBAB5 FOREIGN KEY (useridFollowed) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE administrateur ADD CONSTRAINT FK_32EB52E8FE6E88D7 FOREIGN KEY (idUser) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0391C87D5 FOREIGN KEY (idProduit) REFERENCES produit (idProduit)');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF088055874 FOREIGN KEY (idEvaluateurUser) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE badge ADD CONSTRAINT FK_FEF0481D64B64DCC FOREIGN KEY (userId) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE badge ADD CONSTRAINT FK_FEF0481D31B588BA FOREIGN KEY (testId) REFERENCES test (idTest)');
        $this->addSql('ALTER TABLE candidat ADD CONSTRAINT FK_6AB5B471FE6E88D7 FOREIGN KEY (idUser) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D29A5EC27 FOREIGN KEY (produit) REFERENCES produit (idProduit)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D304AFF9D FOREIGN KEY (acheteur) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D7AF49996 FOREIGN KEY (vendeur) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC7B0C2102 FOREIGN KEY (idPub) REFERENCES publication (idPub)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCFE6E88D7 FOREIGN KEY (idUser) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE competence ADD CONSTRAINT FK_94D4687F64B64DCC FOREIGN KEY (userId) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE cv ADD CONSTRAINT FK_B66FFE9264B64DCC FOREIGN KEY (userId) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE employeur ADD CONSTRAINT FK_8747E1C7FE6E88D7 FOREIGN KEY (idUser) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E69E399D6 FOREIGN KEY (proprietaire) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE experience ADD CONSTRAINT FK_590C10364B64DCC FOREIGN KEY (userId) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866F69E399D6 FOREIGN KEY (proprietaire) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866F90FC4EED FOREIGN KEY (idSecteur) REFERENCES secteur (IdSecteur)');
        $this->addSql('ALTER TABLE participants ADD CONSTRAINT FK_716970922C6A49BA FOREIGN KEY (idEvent) REFERENCES evenement (idEvent)');
        $this->addSql('ALTER TABLE participants ADD CONSTRAINT FK_71697092FE6E88D7 FOREIGN KEY (idUser) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE postulation ADD CONSTRAINT FK_DA7D4E9BB842C572 FOREIGN KEY (idOffre) REFERENCES offre (idOffre)');
        $this->addSql('ALTER TABLE postulation ADD CONSTRAINT FK_DA7D4E9BFE6E88D7 FOREIGN KEY (idUser) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC277AF49996 FOREIGN KEY (vendeur) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C677969E399D6 FOREIGN KEY (proprietaire) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E31B588BA FOREIGN KEY (testId) REFERENCES test (idTest)');
        $this->addSql('ALTER TABLE quiz ADD CONSTRAINT FK_A412FA92AB822092 FOREIGN KEY (idTest) REFERENCES test (idTest)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404FC6CF56E FOREIGN KEY (idAvis) REFERENCES avis (idAvis)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC74B476EBA FOREIGN KEY (questionId) REFERENCES question (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE abonnement DROP FOREIGN KEY FK_351268BBF132696E');
        $this->addSql('ALTER TABLE abonnement DROP FOREIGN KEY FK_351268BB53DDBAB5');
        $this->addSql('ALTER TABLE administrateur DROP FOREIGN KEY FK_32EB52E8FE6E88D7');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF0391C87D5');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF088055874');
        $this->addSql('ALTER TABLE badge DROP FOREIGN KEY FK_FEF0481D64B64DCC');
        $this->addSql('ALTER TABLE badge DROP FOREIGN KEY FK_FEF0481D31B588BA');
        $this->addSql('ALTER TABLE candidat DROP FOREIGN KEY FK_6AB5B471FE6E88D7');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D29A5EC27');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D304AFF9D');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D7AF49996');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC7B0C2102');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCFE6E88D7');
        $this->addSql('ALTER TABLE competence DROP FOREIGN KEY FK_94D4687F64B64DCC');
        $this->addSql('ALTER TABLE cv DROP FOREIGN KEY FK_B66FFE9264B64DCC');
        $this->addSql('ALTER TABLE employeur DROP FOREIGN KEY FK_8747E1C7FE6E88D7');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E69E399D6');
        $this->addSql('ALTER TABLE experience DROP FOREIGN KEY FK_590C10364B64DCC');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866F69E399D6');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866F90FC4EED');
        $this->addSql('ALTER TABLE participants DROP FOREIGN KEY FK_716970922C6A49BA');
        $this->addSql('ALTER TABLE participants DROP FOREIGN KEY FK_71697092FE6E88D7');
        $this->addSql('ALTER TABLE postulation DROP FOREIGN KEY FK_DA7D4E9BB842C572');
        $this->addSql('ALTER TABLE postulation DROP FOREIGN KEY FK_DA7D4E9BFE6E88D7');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC277AF49996');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C677969E399D6');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E31B588BA');
        $this->addSql('ALTER TABLE quiz DROP FOREIGN KEY FK_A412FA92AB822092');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404FC6CF56E');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC74B476EBA');
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
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE quiz');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE reponse');
        $this->addSql('DROP TABLE secteur');
        $this->addSql('DROP TABLE test');
        $this->addSql('DROP TABLE user');
    }
}
