<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230406010849 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis ADD id_avis VARCHAR(255) NOT NULL, DROP idAvis, CHANGE description description VARCHAR(100) NOT NULL, CHANGE note note VARCHAR(255) NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id_avis)');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0391C87D5 FOREIGN KEY (idProduit) REFERENCES produit (idProduit)');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF088055874 FOREIGN KEY (idEvaluateurUser) REFERENCES user (idUser)');
        $this->addSql('DROP INDEX avis_prod ON avis');
        $this->addSql('CREATE INDEX IDX_8F91ABF0391C87D5 ON avis (idProduit)');
        $this->addSql('DROP INDEX idevaluateuruser ON avis');
        $this->addSql('CREATE INDEX IDX_8F91ABF088055874 ON avis (idEvaluateurUser)');
        $this->addSql('ALTER TABLE badge DROP FOREIGN KEY badge_ibfk_2');
        $this->addSql('ALTER TABLE badge DROP FOREIGN KEY badge_ibfk_1');
        $this->addSql('ALTER TABLE badge CHANGE date date DATETIME NOT NULL, CHANGE userId userId INT DEFAULT NULL, CHANGE testId testId INT DEFAULT NULL');
        $this->addSql('DROP INDEX userid ON badge');
        $this->addSql('CREATE INDEX IDX_FEF0481D64B64DCC ON badge (userId)');
        $this->addSql('DROP INDEX testid ON badge');
        $this->addSql('CREATE INDEX IDX_FEF0481D31B588BA ON badge (testId)');
        $this->addSql('ALTER TABLE badge ADD CONSTRAINT badge_ibfk_2 FOREIGN KEY (testId) REFERENCES test (idTest)');
        $this->addSql('ALTER TABLE badge ADD CONSTRAINT badge_ibfk_1 FOREIGN KEY (userId) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE candidat DROP FOREIGN KEY candidat_ibfk_1');
        $this->addSql('ALTER TABLE candidat CHANGE idCandidat idcandidat VARCHAR(255) NOT NULL, CHANGE idUser idUser INT DEFAULT NULL');
        $this->addSql('DROP INDEX iduser ON candidat');
        $this->addSql('CREATE INDEX IDX_6AB5B471FE6E88D7 ON candidat (idUser)');
        $this->addSql('ALTER TABLE candidat ADD CONSTRAINT candidat_ibfk_1 FOREIGN KEY (idUser) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY commande_ibfk_2');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY commande_ibfk_3');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY commande_ibfk_1');
        $this->addSql('ALTER TABLE commande CHANGE id_commande id_commande VARCHAR(255) NOT NULL, CHANGE acheteur acheteur INT DEFAULT NULL, CHANGE vendeur vendeur INT DEFAULT NULL, CHANGE produit produit INT DEFAULT NULL');
        $this->addSql('DROP INDEX produit ON commande');
        $this->addSql('CREATE INDEX IDX_6EEAA67D29A5EC27 ON commande (produit)');
        $this->addSql('DROP INDEX acheteur ON commande');
        $this->addSql('CREATE INDEX IDX_6EEAA67D304AFF9D ON commande (acheteur)');
        $this->addSql('DROP INDEX vendeur ON commande');
        $this->addSql('CREATE INDEX IDX_6EEAA67D7AF49996 ON commande (vendeur)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT commande_ibfk_2 FOREIGN KEY (vendeur) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT commande_ibfk_3 FOREIGN KEY (produit) REFERENCES produit (idProduit)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT commande_ibfk_1 FOREIGN KEY (acheteur) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY commentaire_ibfk_1');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY commentaire_ibfk_2');
        $this->addSql('ALTER TABLE commentaire CHANGE idPub idPub INT DEFAULT NULL, CHANGE idUser idUser INT DEFAULT NULL');
        $this->addSql('DROP INDEX idpub ON commentaire');
        $this->addSql('CREATE INDEX IDX_67F068BC7B0C2102 ON commentaire (idPub)');
        $this->addSql('DROP INDEX iduser ON commentaire');
        $this->addSql('CREATE INDEX IDX_67F068BCFE6E88D7 ON commentaire (idUser)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT commentaire_ibfk_1 FOREIGN KEY (idPub) REFERENCES publication (idPub)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT commentaire_ibfk_2 FOREIGN KEY (idUser) REFERENCES user (idUser)');
        $this->addSql('DROP INDEX `primary` ON competence');
        $this->addSql('ALTER TABLE competence DROP FOREIGN KEY competence_ibfk_1');
        $this->addSql('ALTER TABLE competence CHANGE userId userId INT DEFAULT NULL');
        $this->addSql('ALTER TABLE competence ADD PRIMARY KEY (libelle)');
        $this->addSql('DROP INDEX userid ON competence');
        $this->addSql('CREATE INDEX IDX_94D4687F64B64DCC ON competence (userId)');
        $this->addSql('ALTER TABLE competence ADD CONSTRAINT competence_ibfk_1 FOREIGN KEY (userId) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE cv DROP FOREIGN KEY cv_ibfk_1');
        $this->addSql('ALTER TABLE cv CHANGE dateNaissance datenaissance DATETIME NOT NULL, CHANGE photo photo VARCHAR(255) NOT NULL, CHANGE adresse adresse VARCHAR(255) NOT NULL, CHANGE langue langue VARCHAR(255) NOT NULL, CHANGE education education VARCHAR(255) NOT NULL, CHANGE userId userId INT DEFAULT NULL');
        $this->addSql('DROP INDEX userid ON cv');
        $this->addSql('CREATE INDEX IDX_B66FFE9264B64DCC ON cv (userId)');
        $this->addSql('ALTER TABLE cv ADD CONSTRAINT cv_ibfk_1 FOREIGN KEY (userId) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE employeur DROP FOREIGN KEY employeur_ibfk_1');
        $this->addSql('ALTER TABLE employeur CHANGE idEmployeur idemployeur VARCHAR(255) NOT NULL, CHANGE idUser idUser INT DEFAULT NULL');
        $this->addSql('DROP INDEX iduser ON employeur');
        $this->addSql('CREATE INDEX IDX_8747E1C7FE6E88D7 ON employeur (idUser)');
        $this->addSql('ALTER TABLE employeur ADD CONSTRAINT employeur_ibfk_1 FOREIGN KEY (idUser) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY fk_event');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY fk_event');
        $this->addSql('ALTER TABLE evenement CHANGE proprietaire proprietaire INT DEFAULT NULL, CHANGE dateEvent dateevent VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E69E399D6 FOREIGN KEY (proprietaire) REFERENCES user (idUser)');
        $this->addSql('DROP INDEX fk_event ON evenement');
        $this->addSql('CREATE INDEX IDX_B26681E69E399D6 ON evenement (proprietaire)');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT fk_event FOREIGN KEY (proprietaire) REFERENCES user (idUser) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE experience DROP FOREIGN KEY experience_ibfk_1');
        $this->addSql('ALTER TABLE experience CHANGE description description VARCHAR(255) DEFAULT NULL, CHANGE lieu lieu VARCHAR(50) DEFAULT NULL, CHANGE userId userId INT DEFAULT NULL');
        $this->addSql('DROP INDEX userid ON experience');
        $this->addSql('CREATE INDEX IDX_590C10364B64DCC ON experience (userId)');
        $this->addSql('ALTER TABLE experience ADD CONSTRAINT experience_ibfk_1 FOREIGN KEY (userId) REFERENCES user (idUser)');
        $this->addSql('DROP INDEX email ON maillist');
        $this->addSql('ALTER TABLE participants DROP FOREIGN KEY participants_ibfk_1');
        $this->addSql('ALTER TABLE participants DROP FOREIGN KEY participants_ibfk_2');
        $this->addSql('ALTER TABLE participants CHANGE idEvent idEvent INT DEFAULT NULL, CHANGE idUser idUser INT DEFAULT NULL');
        $this->addSql('DROP INDEX idevent ON participants');
        $this->addSql('CREATE INDEX IDX_716970922C6A49BA ON participants (idEvent)');
        $this->addSql('DROP INDEX iduser ON participants');
        $this->addSql('CREATE INDEX IDX_71697092FE6E88D7 ON participants (idUser)');
        $this->addSql('ALTER TABLE participants ADD CONSTRAINT participants_ibfk_1 FOREIGN KEY (idEvent) REFERENCES evenement (idEvent)');
        $this->addSql('ALTER TABLE participants ADD CONSTRAINT participants_ibfk_2 FOREIGN KEY (idUser) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY produit_ibfk_1');
        $this->addSql('ALTER TABLE produit CHANGE vendeur vendeur INT DEFAULT NULL, CHANGE image image VARCHAR(255) NOT NULL, CHANGE prix prix NUMERIC(10, 2) DEFAULT NULL');
        $this->addSql('DROP INDEX vendeur ON produit');
        $this->addSql('CREATE INDEX IDX_29A5EC277AF49996 ON produit (vendeur)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT produit_ibfk_1 FOREIGN KEY (vendeur) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY fk_pub');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY fk_pub');
        $this->addSql('ALTER TABLE publication CHANGE proprietaire proprietaire INT DEFAULT NULL, CHANGE datePub datepub VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C677969E399D6 FOREIGN KEY (proprietaire) REFERENCES user (idUser)');
        $this->addSql('DROP INDEX fk_pub ON publication');
        $this->addSql('CREATE INDEX IDX_AF3C677969E399D6 ON publication (proprietaire)');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT fk_pub FOREIGN KEY (proprietaire) REFERENCES user (idUser) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE quiz DROP FOREIGN KEY quiz_ibfk_1');
        $this->addSql('ALTER TABLE quiz CHANGE idTest idTest INT DEFAULT NULL');
        $this->addSql('DROP INDEX idtest ON quiz');
        $this->addSql('CREATE INDEX IDX_A412FA92AB822092 ON quiz (idTest)');
        $this->addSql('ALTER TABLE quiz ADD CONSTRAINT quiz_ibfk_1 FOREIGN KEY (idTest) REFERENCES test (idTest)');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY reclamation_ibfk_1');
        $this->addSql('ALTER TABLE reclamation ADD idAvis VARCHAR(255) DEFAULT NULL, CHANGE id id VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404FC6CF56E FOREIGN KEY (idAvis) REFERENCES avis (idAvis)');
        $this->addSql('CREATE INDEX IDX_CE606404FC6CF56E ON reclamation (idAvis)');
        $this->addSql('DROP INDEX email ON user');
        $this->addSql('ALTER TABLE user CHANGE bio bio VARCHAR(65535) NOT NULL, CHANGE photoPath photoPath VARCHAR(255) NOT NULL, CHANGE numTel numTel VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis MODIFY id_avis VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF0391C87D5');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF088055874');
        $this->addSql('DROP INDEX `PRIMARY` ON avis');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF0391C87D5');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF088055874');
        $this->addSql('ALTER TABLE avis ADD idAvis INT AUTO_INCREMENT NOT NULL, DROP id_avis, CHANGE description description TEXT NOT NULL, CHANGE note note INT NOT NULL');
        $this->addSql('ALTER TABLE avis ADD PRIMARY KEY (idAvis)');
        $this->addSql('DROP INDEX idx_8f91abf0391c87d5 ON avis');
        $this->addSql('CREATE INDEX avis_prod ON avis (idProduit)');
        $this->addSql('DROP INDEX idx_8f91abf088055874 ON avis');
        $this->addSql('CREATE INDEX idEvaluateurUser ON avis (idEvaluateurUser)');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0391C87D5 FOREIGN KEY (idProduit) REFERENCES produit (idProduit)');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF088055874 FOREIGN KEY (idEvaluateurUser) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE badge DROP FOREIGN KEY FK_FEF0481D64B64DCC');
        $this->addSql('ALTER TABLE badge DROP FOREIGN KEY FK_FEF0481D31B588BA');
        $this->addSql('ALTER TABLE badge CHANGE date date DATE NOT NULL, CHANGE userId userId INT NOT NULL, CHANGE testId testId INT NOT NULL');
        $this->addSql('DROP INDEX idx_fef0481d64b64dcc ON badge');
        $this->addSql('CREATE INDEX userId ON badge (userId)');
        $this->addSql('DROP INDEX idx_fef0481d31b588ba ON badge');
        $this->addSql('CREATE INDEX testId ON badge (testId)');
        $this->addSql('ALTER TABLE badge ADD CONSTRAINT FK_FEF0481D64B64DCC FOREIGN KEY (userId) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE badge ADD CONSTRAINT FK_FEF0481D31B588BA FOREIGN KEY (testId) REFERENCES test (idTest)');
        $this->addSql('ALTER TABLE candidat DROP FOREIGN KEY FK_6AB5B471FE6E88D7');
        $this->addSql('ALTER TABLE candidat CHANGE idcandidat idCandidat INT AUTO_INCREMENT NOT NULL, CHANGE idUser idUser INT NOT NULL');
        $this->addSql('DROP INDEX idx_6ab5b471fe6e88d7 ON candidat');
        $this->addSql('CREATE INDEX idUser ON candidat (idUser)');
        $this->addSql('ALTER TABLE candidat ADD CONSTRAINT FK_6AB5B471FE6E88D7 FOREIGN KEY (idUser) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D29A5EC27');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D304AFF9D');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D7AF49996');
        $this->addSql('ALTER TABLE commande CHANGE id_commande id_commande INT AUTO_INCREMENT NOT NULL, CHANGE produit produit INT NOT NULL, CHANGE acheteur acheteur INT NOT NULL, CHANGE vendeur vendeur INT NOT NULL');
        $this->addSql('DROP INDEX idx_6eeaa67d304aff9d ON commande');
        $this->addSql('CREATE INDEX acheteur ON commande (acheteur)');
        $this->addSql('DROP INDEX idx_6eeaa67d7af49996 ON commande');
        $this->addSql('CREATE INDEX vendeur ON commande (vendeur)');
        $this->addSql('DROP INDEX idx_6eeaa67d29a5ec27 ON commande');
        $this->addSql('CREATE INDEX produit ON commande (produit)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D29A5EC27 FOREIGN KEY (produit) REFERENCES produit (idProduit)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D304AFF9D FOREIGN KEY (acheteur) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D7AF49996 FOREIGN KEY (vendeur) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC7B0C2102');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCFE6E88D7');
        $this->addSql('ALTER TABLE commentaire CHANGE idPub idPub INT NOT NULL, CHANGE idUser idUser INT NOT NULL');
        $this->addSql('DROP INDEX idx_67f068bc7b0c2102 ON commentaire');
        $this->addSql('CREATE INDEX idPub ON commentaire (idPub)');
        $this->addSql('DROP INDEX idx_67f068bcfe6e88d7 ON commentaire');
        $this->addSql('CREATE INDEX idUser ON commentaire (idUser)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC7B0C2102 FOREIGN KEY (idPub) REFERENCES publication (idPub)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCFE6E88D7 FOREIGN KEY (idUser) REFERENCES user (idUser)');
        $this->addSql('DROP INDEX `PRIMARY` ON competence');
        $this->addSql('ALTER TABLE competence DROP FOREIGN KEY FK_94D4687F64B64DCC');
        $this->addSql('ALTER TABLE competence CHANGE userId userId INT NOT NULL');
        $this->addSql('ALTER TABLE competence ADD PRIMARY KEY (libelle, userId)');
        $this->addSql('DROP INDEX idx_94d4687f64b64dcc ON competence');
        $this->addSql('CREATE INDEX userId ON competence (userId)');
        $this->addSql('ALTER TABLE competence ADD CONSTRAINT FK_94D4687F64B64DCC FOREIGN KEY (userId) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE cv DROP FOREIGN KEY FK_B66FFE9264B64DCC');
        $this->addSql('ALTER TABLE cv CHANGE datenaissance dateNaissance DATE DEFAULT NULL, CHANGE photo photo VARCHAR(255) DEFAULT NULL, CHANGE adresse adresse VARCHAR(255) DEFAULT NULL, CHANGE langue langue VARCHAR(255) DEFAULT NULL, CHANGE education education VARCHAR(255) DEFAULT NULL, CHANGE userId userId INT NOT NULL');
        $this->addSql('DROP INDEX idx_b66ffe9264b64dcc ON cv');
        $this->addSql('CREATE INDEX userId ON cv (userId)');
        $this->addSql('ALTER TABLE cv ADD CONSTRAINT FK_B66FFE9264B64DCC FOREIGN KEY (userId) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE employeur DROP FOREIGN KEY FK_8747E1C7FE6E88D7');
        $this->addSql('ALTER TABLE employeur CHANGE idemployeur idEmployeur INT AUTO_INCREMENT NOT NULL, CHANGE idUser idUser INT NOT NULL');
        $this->addSql('DROP INDEX idx_8747e1c7fe6e88d7 ON employeur');
        $this->addSql('CREATE INDEX idUser ON employeur (idUser)');
        $this->addSql('ALTER TABLE employeur ADD CONSTRAINT FK_8747E1C7FE6E88D7 FOREIGN KEY (idUser) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E69E399D6');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E69E399D6');
        $this->addSql('ALTER TABLE evenement CHANGE proprietaire proprietaire INT NOT NULL, CHANGE dateevent dateEvent DATE NOT NULL');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT fk_event FOREIGN KEY (proprietaire) REFERENCES user (idUser) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('DROP INDEX idx_b26681e69e399d6 ON evenement');
        $this->addSql('CREATE INDEX fk_event ON evenement (proprietaire)');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E69E399D6 FOREIGN KEY (proprietaire) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE experience DROP FOREIGN KEY FK_590C10364B64DCC');
        $this->addSql('ALTER TABLE experience CHANGE description description TEXT DEFAULT NULL, CHANGE lieu lieu VARCHAR(255) DEFAULT NULL, CHANGE userId userId INT NOT NULL');
        $this->addSql('DROP INDEX idx_590c10364b64dcc ON experience');
        $this->addSql('CREATE INDEX userId ON experience (userId)');
        $this->addSql('ALTER TABLE experience ADD CONSTRAINT FK_590C10364B64DCC FOREIGN KEY (userId) REFERENCES user (idUser)');
        $this->addSql('CREATE UNIQUE INDEX email ON maillist (email)');
        $this->addSql('ALTER TABLE participants DROP FOREIGN KEY FK_716970922C6A49BA');
        $this->addSql('ALTER TABLE participants DROP FOREIGN KEY FK_71697092FE6E88D7');
        $this->addSql('ALTER TABLE participants CHANGE idEvent idEvent INT NOT NULL, CHANGE idUser idUser INT NOT NULL');
        $this->addSql('DROP INDEX idx_71697092fe6e88d7 ON participants');
        $this->addSql('CREATE INDEX idUser ON participants (idUser)');
        $this->addSql('DROP INDEX idx_716970922c6a49ba ON participants');
        $this->addSql('CREATE INDEX idEvent ON participants (idEvent)');
        $this->addSql('ALTER TABLE participants ADD CONSTRAINT FK_716970922C6A49BA FOREIGN KEY (idEvent) REFERENCES evenement (idEvent)');
        $this->addSql('ALTER TABLE participants ADD CONSTRAINT FK_71697092FE6E88D7 FOREIGN KEY (idUser) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC277AF49996');
        $this->addSql('ALTER TABLE produit CHANGE vendeur vendeur INT NOT NULL, CHANGE image image VARCHAR(255) DEFAULT NULL, CHANGE prix prix NUMERIC(10, 2) NOT NULL');
        $this->addSql('DROP INDEX idx_29a5ec277af49996 ON produit');
        $this->addSql('CREATE INDEX vendeur ON produit (vendeur)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC277AF49996 FOREIGN KEY (vendeur) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C677969E399D6');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C677969E399D6');
        $this->addSql('ALTER TABLE publication CHANGE proprietaire proprietaire INT NOT NULL, CHANGE datepub datePub DATE NOT NULL');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT fk_pub FOREIGN KEY (proprietaire) REFERENCES user (idUser) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('DROP INDEX idx_af3c677969e399d6 ON publication');
        $this->addSql('CREATE INDEX fk_pub ON publication (proprietaire)');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C677969E399D6 FOREIGN KEY (proprietaire) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE quiz DROP FOREIGN KEY FK_A412FA92AB822092');
        $this->addSql('ALTER TABLE quiz CHANGE idTest idTest INT NOT NULL');
        $this->addSql('DROP INDEX idx_a412fa92ab822092 ON quiz');
        $this->addSql('CREATE INDEX idTest ON quiz (idTest)');
        $this->addSql('ALTER TABLE quiz ADD CONSTRAINT FK_A412FA92AB822092 FOREIGN KEY (idTest) REFERENCES test (idTest)');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404FC6CF56E');
        $this->addSql('DROP INDEX IDX_CE606404FC6CF56E ON reclamation');
        $this->addSql('ALTER TABLE reclamation DROP idAvis, CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT reclamation_ibfk_1 FOREIGN KEY (id) REFERENCES avis (idAvis)');
        $this->addSql('ALTER TABLE user CHANGE bio bio TEXT DEFAULT NULL, CHANGE photoPath photoPath VARCHAR(255) DEFAULT NULL, CHANGE numTel numTel VARCHAR(255) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX email ON user (email)');
    }
}
