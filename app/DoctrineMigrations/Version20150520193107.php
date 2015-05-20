<?php

namespace Destruktiv\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150520193107 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE Message (id INT AUTO_INCREMENT NOT NULL, thread_id INT DEFAULT NULL, sender_id INT DEFAULT NULL, body LONGTEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_790009E3E2904019 (thread_id), INDEX IDX_790009E3F624B39D (sender_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE MessageMetadata (id INT AUTO_INCREMENT NOT NULL, message_id INT DEFAULT NULL, participant_id INT DEFAULT NULL, is_read TINYINT(1) NOT NULL, INDEX IDX_DA67B3AD537A1329 (message_id), INDEX IDX_DA67B3AD9D1C3019 (participant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE MessageThread (id INT AUTO_INCREMENT NOT NULL, subject VARCHAR(255) NOT NULL, createdAt DATETIME NOT NULL, isSpam TINYINT(1) NOT NULL, createdBy_id INT DEFAULT NULL, INDEX IDX_F06C11373174800F (createdBy_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE MessageThreadMetadata (id INT AUTO_INCREMENT NOT NULL, thread_id INT DEFAULT NULL, participant_id INT DEFAULT NULL, is_deleted TINYINT(1) NOT NULL, last_participant_message_date DATETIME DEFAULT NULL, last_message_date DATETIME DEFAULT NULL, INDEX IDX_CFC10420E2904019 (thread_id), INDEX IDX_CFC104209D1C3019 (participant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Message ADD CONSTRAINT FK_790009E3E2904019 FOREIGN KEY (thread_id) REFERENCES MessageThread (id)');
        $this->addSql('ALTER TABLE Message ADD CONSTRAINT FK_790009E3F624B39D FOREIGN KEY (sender_id) REFERENCES User (id)');
        $this->addSql('ALTER TABLE MessageMetadata ADD CONSTRAINT FK_DA67B3AD537A1329 FOREIGN KEY (message_id) REFERENCES Message (id)');
        $this->addSql('ALTER TABLE MessageMetadata ADD CONSTRAINT FK_DA67B3AD9D1C3019 FOREIGN KEY (participant_id) REFERENCES User (id)');
        $this->addSql('ALTER TABLE MessageThread ADD CONSTRAINT FK_F06C11373174800F FOREIGN KEY (createdBy_id) REFERENCES User (id)');
        $this->addSql('ALTER TABLE MessageThreadMetadata ADD CONSTRAINT FK_CFC10420E2904019 FOREIGN KEY (thread_id) REFERENCES MessageThread (id)');
        $this->addSql('ALTER TABLE MessageThreadMetadata ADD CONSTRAINT FK_CFC104209D1C3019 FOREIGN KEY (participant_id) REFERENCES User (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE MessageMetadata DROP FOREIGN KEY FK_DA67B3AD537A1329');
        $this->addSql('ALTER TABLE Message DROP FOREIGN KEY FK_790009E3E2904019');
        $this->addSql('ALTER TABLE MessageThreadMetadata DROP FOREIGN KEY FK_CFC10420E2904019');
        $this->addSql('DROP TABLE Message');
        $this->addSql('DROP TABLE MessageMetadata');
        $this->addSql('DROP TABLE MessageThread');
        $this->addSql('DROP TABLE MessageThreadMetadata');
    }
}
