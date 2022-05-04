<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220425210101 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD firstname VARCHAR(180) NOT NULL, ADD lastname VARCHAR(180) NOT NULL, ADD age INT NOT NULL, ADD phonenumber VARCHAR(8) DEFAULT NULL, ADD image VARCHAR(255) NOT NULL, DROP nom, DROP prenom, DROP adresse, DROP numero, DROP token, DROP valide');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD prenom VARCHAR(255) NOT NULL, ADD adresse VARCHAR(255) NOT NULL, ADD numero VARCHAR(255) NOT NULL, ADD valide INT NOT NULL, DROP firstname, DROP lastname, DROP phonenumber, CHANGE image nom VARCHAR(255) NOT NULL, CHANGE age token INT NOT NULL');
    }
}
