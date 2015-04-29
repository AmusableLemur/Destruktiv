<?php

namespace Destruktiv\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150429160914 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Post ADD author_id INT DEFAULT NULL, ADD dateCreated DATETIME NOT NULL, ADD dateUpdated DATETIME NOT NULL');
        $this->addSql('ALTER TABLE Post ADD CONSTRAINT FK_FAB8C3B3F675F31B FOREIGN KEY (author_id) REFERENCES User (id)');
        $this->addSql('CREATE INDEX IDX_FAB8C3B3F675F31B ON Post (author_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Post DROP FOREIGN KEY FK_FAB8C3B3F675F31B');
        $this->addSql('DROP INDEX IDX_FAB8C3B3F675F31B ON Post');
        $this->addSql('ALTER TABLE Post DROP author_id, DROP dateCreated, DROP dateUpdated');
    }
}
