<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230411072133 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE test_quiz (test_id INT NOT NULL, quiz_id INT NOT NULL, INDEX IDX_A16BD05D1E5D0459 (test_id), INDEX IDX_A16BD05D853CD175 (quiz_id), PRIMARY KEY(test_id, quiz_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE test_quiz ADD CONSTRAINT FK_A16BD05D1E5D0459 FOREIGN KEY (test_id) REFERENCES test (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE test_quiz ADD CONSTRAINT FK_A16BD05D853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE abonnement DROP FOREIGN KEY abonnement_ibfk_2');
        $this->addSql('ALTER TABLE abonnement DROP FOREIGN KEY abonnement_ibfk_1');
        $this->addSql('ALTER TABLE administrateur DROP FOREIGN KEY administrateur_ibfk_1');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY avis_prod');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY avis_ibfk_1');
        $this->addSql('ALTER TABLE badge DROP FOREIGN KEY badge_ibfk_1');
        $this->addSql('ALTER TABLE badge DROP FOREIGN KEY badge_ibfk_2');
        $this->addSql('ALTER TABLE candidat DROP FOREIGN KEY candidat_ibfk_1');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY commande_ibfk_3');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY commande_ibfk_1');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY commande_ibfk_2');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY commentaire_ibfk_1');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY commentaire_ibfk_2');
        $this->addSql('ALTER TABLE competence DROP FOREIGN KEY competence_ibfk_1');
        $this->addSql('ALTER TABLE cv DROP FOREIGN KEY cv_ibfk_1');
        $this->addSql('ALTER TABLE employeur DROP FOREIGN KEY employeur_ibfk_1');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY fk_event');
        $this->addSql('ALTER TABLE experience DROP FOREIGN KEY experience_ibfk_1');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY offre_ibfk_21');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY offre_ibfk_1');
        $this->addSql('ALTER TABLE participants DROP FOREIGN KEY participants_ibfk_2');
        $this->addSql('ALTER TABLE participants DROP FOREIGN KEY participants_ibfk_1');
        $this->addSql('ALTER TABLE postulation DROP FOREIGN KEY postulation_ibfk_1');
        $this->addSql('ALTER TABLE postulation DROP FOREIGN KEY postulation_ibfk_2');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY produit_ibfk_1');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY fk_pub');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY question_ibfk_1');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY reclamation_ibfk_1');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY reponse_ibfk_1');
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
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE reponse');
        $this->addSql('DROP TABLE secteur');
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE quiz DROP FOREIGN KEY quiz_ibfk_1');
        $this->addSql('DROP INDEX idTest ON quiz');
        $this->addSql('ALTER TABLE quiz DROP idTest');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE abonnement (idAbonnement INT AUTO_INCREMENT NOT NULL, userId INT NOT NULL, userIdFollowed INT NOT NULL, INDEX userId (userId), INDEX userIdFollowed (userIdFollowed), PRIMARY KEY(idAbonnement)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE administrateur (pseudo VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, idUser INT NOT NULL, INDEX idUser (idUser), PRIMARY KEY(pseudo)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE avis (id INT AUTO_INCREMENT NOT NULL, idEvaluateurUser INT DEFAULT NULL, idProduit INT DEFAULT NULL, description TEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, note INT NOT NULL, date DATE NOT NULL, INDEX idEvaluateurUser (idEvaluateurUser), INDEX avis_prod (idProduit), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE badge (idBadge INT AUTO_INCREMENT NOT NULL, nomBadge VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, date DATE NOT NULL, userId INT NOT NULL, testId INT NOT NULL, INDEX userId (userId), INDEX testId (testId), PRIMARY KEY(idBadge)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE candidat (idCandidat INT AUTO_INCREMENT NOT NULL, idUser INT NOT NULL, secteur VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, INDEX idUser (idUser), PRIMARY KEY(idCandidat)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE commande (acheteur INT NOT NULL, vendeur INT NOT NULL, produit INT NOT NULL, idCommande INT AUTO_INCREMENT NOT NULL, dateCommande DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, montantPaye NUMERIC(10, 2) NOT NULL, INDEX acheteur (acheteur), INDEX vendeur (vendeur), INDEX produit (produit), PRIMARY KEY(idCommande)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE commentaire (idComm INT AUTO_INCREMENT NOT NULL, commentaire VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, idPub INT NOT NULL, idUser INT NOT NULL, INDEX idPub (idPub), INDEX idUser (idUser), PRIMARY KEY(idComm)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE competence (libelle VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, userId INT NOT NULL, INDEX userId (userId), PRIMARY KEY(libelle, userId)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE cv (idCV INT AUTO_INCREMENT NOT NULL, cin INT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, prenom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, sexe VARCHAR(10) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, dateNaissance DATE DEFAULT NULL, photo VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, adresse VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, langue VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, education VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, userId INT NOT NULL, INDEX userId (userId), PRIMARY KEY(idCV)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE employeur (idEmployeur INT AUTO_INCREMENT NOT NULL, idUser INT NOT NULL, companyName VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, secteur VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, INDEX idUser (idUser), PRIMARY KEY(idEmployeur)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE evenement (proprietaire INT NOT NULL, idEvent INT AUTO_INCREMENT NOT NULL, titre VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, sujet VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, lieu VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, horaire VARCHAR(10) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, dateEvent DATE NOT NULL, INDEX fk_event (proprietaire), PRIMARY KEY(idEvent)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE experience (idExperience INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, description TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, type VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, lieu VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, secteur VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, dateDebut DATE DEFAULT NULL, dateFin DATE DEFAULT NULL, userId INT NOT NULL, INDEX userId (userId), PRIMARY KEY(idExperience)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE maillist (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, UNIQUE INDEX email (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE offre (proprietaire INT NOT NULL, idOffre INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, typeOffre VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, description TEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, dateDebut DATE NOT NULL, dateFin DATE DEFAULT NULL, competence TEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, idSecteur INT DEFAULT NULL, INDEX proprietaire (proprietaire), INDEX offre_ibfk_21 (idSecteur), PRIMARY KEY(idOffre)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE participants (idParticipant INT AUTO_INCREMENT NOT NULL, idEvent INT NOT NULL, idUser INT NOT NULL, INDEX idEvent (idEvent), INDEX idUser (idUser), PRIMARY KEY(idParticipant)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE postulation (idPost INT AUTO_INCREMENT NOT NULL, idOffre INT NOT NULL, idUser INT NOT NULL, INDEX idUser (idUser, idOffre), INDEX idOffre (idOffre, idUser), INDEX IDX_DA7D4E9BB842C572 (idOffre), INDEX IDX_DA7D4E9BFE6E88D7 (idUser), PRIMARY KEY(idPost)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE produit (vendeur INT NOT NULL, idProduit INT AUTO_INCREMENT NOT NULL, categorie VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, description TEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, image VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, prix NUMERIC(10, 2) NOT NULL, date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, INDEX vendeur (vendeur), PRIMARY KEY(idProduit)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE publication (proprietaire INT NOT NULL, idPub INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, datePub DATE NOT NULL, Description VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, cat VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, INDEX fk_pub (proprietaire), PRIMARY KEY(idPub)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, testId INT NOT NULL, INDEX testId (testId), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE reclamation (id INT NOT NULL, nom VARCHAR(10) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, prenom VARCHAR(10) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, sujetdereclamations VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, email VARCHAR(150) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, tel VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, etat VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE reponse (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, estVrai TINYINT(1) DEFAULT NULL, questionId INT DEFAULT NULL, INDEX questionId (questionId), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE secteur (IdSecteur INT AUTO_INCREMENT NOT NULL, nom VARCHAR(25) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, description TEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, DateCreation DATE NOT NULL, DateModification DATE DEFAULT NULL, PRIMARY KEY(IdSecteur)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE user (idUser INT AUTO_INCREMENT NOT NULL, Nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, Prenom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, motDePasse VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, role VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, bio TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, photoPath VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, numTel VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, UNIQUE INDEX email (email), PRIMARY KEY(idUser)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE abonnement ADD CONSTRAINT abonnement_ibfk_2 FOREIGN KEY (userIdFollowed) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE abonnement ADD CONSTRAINT abonnement_ibfk_1 FOREIGN KEY (userId) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE administrateur ADD CONSTRAINT administrateur_ibfk_1 FOREIGN KEY (idUser) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT avis_prod FOREIGN KEY (idProduit) REFERENCES produit (idProduit)');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT avis_ibfk_1 FOREIGN KEY (idEvaluateurUser) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE badge ADD CONSTRAINT badge_ibfk_1 FOREIGN KEY (userId) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE badge ADD CONSTRAINT badge_ibfk_2 FOREIGN KEY (testId) REFERENCES test (id)');
        $this->addSql('ALTER TABLE candidat ADD CONSTRAINT candidat_ibfk_1 FOREIGN KEY (idUser) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT commande_ibfk_3 FOREIGN KEY (produit) REFERENCES produit (idProduit)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT commande_ibfk_1 FOREIGN KEY (acheteur) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT commande_ibfk_2 FOREIGN KEY (vendeur) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT commentaire_ibfk_1 FOREIGN KEY (idPub) REFERENCES publication (idPub)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT commentaire_ibfk_2 FOREIGN KEY (idUser) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE competence ADD CONSTRAINT competence_ibfk_1 FOREIGN KEY (userId) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE cv ADD CONSTRAINT cv_ibfk_1 FOREIGN KEY (userId) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE employeur ADD CONSTRAINT employeur_ibfk_1 FOREIGN KEY (idUser) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT fk_event FOREIGN KEY (proprietaire) REFERENCES user (idUser) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE experience ADD CONSTRAINT experience_ibfk_1 FOREIGN KEY (userId) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT offre_ibfk_21 FOREIGN KEY (idSecteur) REFERENCES secteur (IdSecteur) ON UPDATE SET NULL ON DELETE SET NULL');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT offre_ibfk_1 FOREIGN KEY (proprietaire) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE participants ADD CONSTRAINT participants_ibfk_2 FOREIGN KEY (idUser) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE participants ADD CONSTRAINT participants_ibfk_1 FOREIGN KEY (idEvent) REFERENCES evenement (idEvent)');
        $this->addSql('ALTER TABLE postulation ADD CONSTRAINT postulation_ibfk_1 FOREIGN KEY (idOffre) REFERENCES offre (idOffre)');
        $this->addSql('ALTER TABLE postulation ADD CONSTRAINT postulation_ibfk_2 FOREIGN KEY (idUser) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT produit_ibfk_1 FOREIGN KEY (vendeur) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT fk_pub FOREIGN KEY (proprietaire) REFERENCES user (idUser) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT question_ibfk_1 FOREIGN KEY (testId) REFERENCES test (id)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT reclamation_ibfk_1 FOREIGN KEY (id) REFERENCES avis (id)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT reponse_ibfk_1 FOREIGN KEY (questionId) REFERENCES question (id)');
        $this->addSql('ALTER TABLE test_quiz DROP FOREIGN KEY FK_A16BD05D1E5D0459');
        $this->addSql('ALTER TABLE test_quiz DROP FOREIGN KEY FK_A16BD05D853CD175');
        $this->addSql('DROP TABLE test_quiz');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE quiz ADD idTest INT NOT NULL');
        $this->addSql('ALTER TABLE quiz ADD CONSTRAINT quiz_ibfk_1 FOREIGN KEY (idTest) REFERENCES test (id)');
        $this->addSql('CREATE INDEX idTest ON quiz (idTest)');
    }
}
