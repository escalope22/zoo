<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221209143621 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE enclos (id INT AUTO_INCREMENT NOT NULL, espace_id INT NOT NULL, nom VARCHAR(255) DEFAULT NULL, superficie INT NOT NULL, capacite INT NOT NULL, quarantaine TINYINT(1) NOT NULL, INDEX IDX_8CCECB21B6885C6C (espace_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE enclos ADD CONSTRAINT FK_8CCECB21B6885C6C FOREIGN KEY (espace_id) REFERENCES espaces (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE enclos DROP FOREIGN KEY FK_8CCECB21B6885C6C');
        $this->addSql('DROP TABLE enclos');
    }
}
