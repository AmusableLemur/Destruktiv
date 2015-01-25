<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150123001437 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Invitation ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Invitation ADD CONSTRAINT FK_BE406272A76ED395 FOREIGN KEY (user_id) REFERENCES User (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BE406272A76ED395 ON Invitation (user_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Invitation DROP FOREIGN KEY FK_BE406272A76ED395');
        $this->addSql('DROP INDEX UNIQ_BE406272A76ED395 ON Invitation');
        $this->addSql('ALTER TABLE Invitation DROP user_id');
    }
}
