<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220426213331 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commande (commandeid INT AUTO_INCREMENT NOT NULL, clientid INT DEFAULT NULL, datecreation DATETIME DEFAULT NULL, dateexpedition DATETIME DEFAULT NULL, datearrivee DATETIME DEFAULT NULL, nomclient VARCHAR(255) NOT NULL, nomresto VARCHAR(255) NOT NULL, INDEX IDX_6EEAA67D7F98CD1C (clientid), PRIMARY KEY(commandeid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D7F98CD1C FOREIGN KEY (clientid) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user CHANGE image image VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE commande');
        $this->addSql('ALTER TABLE user CHANGE image image VARCHAR(255) DEFAULT NULL');
    }
}
