<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220426214700 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande MODIFY commandeid INT NOT NULL');
        $this->addSql('ALTER TABLE commande DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE commande CHANGE commandeid id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE commande ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE livraison ADD CONSTRAINT FK_A60C9F1F442B5EFB FOREIGN KEY (idcommande_id) REFERENCES commande (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE commande DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE commande CHANGE id commandeid INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE commande ADD PRIMARY KEY (commandeid)');
        $this->addSql('ALTER TABLE livraison DROP FOREIGN KEY FK_A60C9F1F442B5EFB');
    }
}
