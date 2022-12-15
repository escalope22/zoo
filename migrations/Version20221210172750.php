<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221210172750 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE animals (id INT AUTO_INCREMENT NOT NULL, numero_id BIGINT NOT NULL, nom VARCHAR(255) DEFAULT NULL, date_naissance DATE DEFAULT NULL, date_arrivee DATE NOT NULL, date_depart DATE DEFAULT NULL, zoo_proprietaire TINYINT(1) NOT NULL, genre VARCHAR(255) DEFAULT NULL, espece VARCHAR(255) DEFAULT NULL, male TINYINT(1) DEFAULT NULL, sterilise TINYINT(1) NOT NULL, quarantaine TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE animals');
    }
}
