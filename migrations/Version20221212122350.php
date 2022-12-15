<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221212122350 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animals ADD enclos_id INT NOT NULL');
        $this->addSql('ALTER TABLE animals ADD CONSTRAINT FK_966C69DDB1C0859 FOREIGN KEY (enclos_id) REFERENCES enclos (id)');
        $this->addSql('CREATE INDEX IDX_966C69DDB1C0859 ON animals (enclos_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animals DROP FOREIGN KEY FK_966C69DDB1C0859');
        $this->addSql('DROP INDEX IDX_966C69DDB1C0859 ON animals');
        $this->addSql('ALTER TABLE animals DROP enclos_id');
    }
}
