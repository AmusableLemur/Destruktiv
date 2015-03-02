<?php

namespace Destruktiv\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150302105943 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE User DROP FOREIGN KEY FK_2DA17977A35D7AF0');
        $this->addSql('DROP TABLE Invitation');
        $this->addSql('DROP INDEX UNIQ_2DA17977A35D7AF0 ON User');
        $this->addSql('ALTER TABLE User DROP invitation_id');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE Invitation (code VARCHAR(6) NOT NULL COLLATE utf8_unicode_ci, user_id INT DEFAULT NULL, email VARCHAR(256) NOT NULL COLLATE utf8_unicode_ci, sent TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_BE406272A76ED395 (user_id), PRIMARY KEY(code)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Invitation ADD CONSTRAINT FK_BE406272A76ED395 FOREIGN KEY (user_id) REFERENCES User (id)');
        $this->addSql('ALTER TABLE User ADD invitation_id VARCHAR(6) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE User ADD CONSTRAINT FK_2DA17977A35D7AF0 FOREIGN KEY (invitation_id) REFERENCES Invitation (code)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2DA17977A35D7AF0 ON User (invitation_id)');
    }
}
