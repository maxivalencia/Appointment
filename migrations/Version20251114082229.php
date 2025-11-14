<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251114082229 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE duree_limite_avant_rendez_vous (id INT AUTO_INCREMENT NOT NULL, nombre_heure TIME DEFAULT NULL, date_application DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE historique_rendez_vous (id INT AUTO_INCREMENT NOT NULL, rendez_vous LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jour_speciale (id INT AUTO_INCREMENT NOT NULL, date_speciale DATE DEFAULT NULL, ouvrable TINYINT(1) DEFAULT NULL, heure_debut TIME DEFAULT NULL, heure_fin TIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nombre_jour_maximum_rendez_vous (id INT AUTO_INCREMENT NOT NULL, nombre_jour INT DEFAULT NULL, date_application DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nombre_modification_maximum (id INT AUTO_INCREMENT NOT NULL, nombre_modification INT DEFAULT NULL, date_application DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nombre_rendez_vous_par_heure (id INT AUTO_INCREMENT NOT NULL, nombre_rendez_vous INT DEFAULT NULL, data_application DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nombre_vehicule_maximum_rendez_vous (id INT AUTO_INCREMENT NOT NULL, nombre_vehicule INT DEFAULT NULL, date_application DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ouverture_samedi (id INT AUTO_INCREMENT NOT NULL, date_debut DATE DEFAULT NULL, date_fin DATE DEFAULT NULL, heure_debut TIME DEFAULT NULL, heure_fin TIME DEFAULT NULL, en_vigueur TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rendez_vous (id INT AUTO_INCREMENT NOT NULL, historique_rendez_vous_id INT DEFAULT NULL, immatriculation VARCHAR(255) DEFAULT NULL, proprietaire VARCHAR(255) DEFAULT NULL, contact VARCHAR(255) DEFAULT NULL, mail VARCHAR(255) DEFAULT NULL, adresse VARCHAR(255) DEFAULT NULL, date_prise_rendez_vous DATETIME DEFAULT NULL, date_rendez_vous DATE DEFAULT NULL, heure_rendez_vous TIME DEFAULT NULL, confirmation TINYINT(1) DEFAULT NULL, date_heure_arrive_rendez_vous DATETIME DEFAULT NULL, date_heure_fin_visite DATETIME DEFAULT NULL, date_heure_debut_visite DATETIME DEFAULT NULL, annulation_rendez_vous TINYINT(1) DEFAULT NULL, date_heure_annulation_rendez_vous DATETIME DEFAULT NULL, code_rendez_vous VARCHAR(255) DEFAULT NULL, date_modification_rendez_vous DATETIME DEFAULT NULL, date_origine_rendez_vous DATETIME DEFAULT NULL, nombre_modification INT DEFAULT NULL, INDEX IDX_65E8AA0A72586A80 (historique_rendez_vous_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A72586A80 FOREIGN KEY (historique_rendez_vous_id) REFERENCES historique_rendez_vous (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0A72586A80');
        $this->addSql('DROP TABLE duree_limite_avant_rendez_vous');
        $this->addSql('DROP TABLE historique_rendez_vous');
        $this->addSql('DROP TABLE jour_speciale');
        $this->addSql('DROP TABLE nombre_jour_maximum_rendez_vous');
        $this->addSql('DROP TABLE nombre_modification_maximum');
        $this->addSql('DROP TABLE nombre_rendez_vous_par_heure');
        $this->addSql('DROP TABLE nombre_vehicule_maximum_rendez_vous');
        $this->addSql('DROP TABLE ouverture_samedi');
        $this->addSql('DROP TABLE rendez_vous');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
