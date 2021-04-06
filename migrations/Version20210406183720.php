<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210406183720 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE conversation (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message_prive (id INT AUTO_INCREMENT NOT NULL, user_receiver_id INT DEFAULT NULL, user_issuer_id INT DEFAULT NULL, conversation_id INT DEFAULT NULL, contenue VARCHAR(255) NOT NULL, INDEX IDX_2DB3B2664482423 (user_receiver_id), INDEX IDX_2DB3B26BB7DE20A (user_issuer_id), INDEX IDX_2DB3B269AC0396 (conversation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE message_prive ADD CONSTRAINT FK_2DB3B2664482423 FOREIGN KEY (user_receiver_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE message_prive ADD CONSTRAINT FK_2DB3B26BB7DE20A FOREIGN KEY (user_issuer_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE message_prive ADD CONSTRAINT FK_2DB3B269AC0396 FOREIGN KEY (conversation_id) REFERENCES conversation (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message_prive DROP FOREIGN KEY FK_2DB3B269AC0396');
        $this->addSql('DROP TABLE conversation');
        $this->addSql('DROP TABLE message_prive');
    }
}
