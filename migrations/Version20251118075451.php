<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251118075451 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE centres (id INT AUTO_INCREMENT NOT NULL, province_id INT DEFAULT NULL, centre VARCHAR(255) DEFAULT NULL, code VARCHAR(255) DEFAULT NULL, INDEX IDX_3BA7EA52E946114A (province_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE provinces (id INT AUTO_INCREMENT NOT NULL, province VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE centres ADD CONSTRAINT FK_3BA7EA52E946114A FOREIGN KEY (province_id) REFERENCES provinces (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD centre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A463CD7C3 FOREIGN KEY (centre_id) REFERENCES centres (id)');
        $this->addSql('CREATE INDEX IDX_65E8AA0A463CD7C3 ON rendez_vous (centre_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0A463CD7C3');
        $this->addSql('ALTER TABLE centres DROP FOREIGN KEY FK_3BA7EA52E946114A');
        $this->addSql('DROP TABLE centres');
        $this->addSql('DROP TABLE provinces');
        $this->addSql('DROP INDEX IDX_65E8AA0A463CD7C3 ON rendez_vous');
        $this->addSql('ALTER TABLE rendez_vous DROP centre_id');
    }
}
