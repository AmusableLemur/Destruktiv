<?php

namespace Destruktiv\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150428204609 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Post ADD thread_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Post ADD CONSTRAINT FK_FAB8C3B3E2904019 FOREIGN KEY (thread_id) REFERENCES Thread (id)');
        $this->addSql('CREATE INDEX IDX_FAB8C3B3E2904019 ON Post (thread_id)');
        $this->addSql('ALTER TABLE Thread ADD author_id INT DEFAULT NULL, ADD title VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE Thread ADD CONSTRAINT FK_368C49B5F675F31B FOREIGN KEY (author_id) REFERENCES User (id)');
        $this->addSql('CREATE INDEX IDX_368C49B5F675F31B ON Thread (author_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Post DROP FOREIGN KEY FK_FAB8C3B3E2904019');
        $this->addSql('DROP INDEX IDX_FAB8C3B3E2904019 ON Post');
        $this->addSql('ALTER TABLE Post DROP thread_id');
        $this->addSql('ALTER TABLE Thread DROP FOREIGN KEY FK_368C49B5F675F31B');
        $this->addSql('DROP INDEX IDX_368C49B5F675F31B ON Thread');
        $this->addSql('ALTER TABLE Thread DROP author_id, DROP title');
    }
}
