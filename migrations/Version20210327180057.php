<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210327180057 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE abonnement (id INT AUTO_INCREMENT NOT NULL, user_receiver_id INT NOT NULL, user_issuer_id INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_351268BB64482423 (user_receiver_id), INDEX IDX_351268BBBB7DE20A (user_issuer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE like_publication (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, publication_id INT NOT NULL, INDEX IDX_1CF989F7A76ED395 (user_id), INDEX IDX_1CF989F738B217A7 (publication_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE abonnement ADD CONSTRAINT FK_351268BB64482423 FOREIGN KEY (user_receiver_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE abonnement ADD CONSTRAINT FK_351268BBBB7DE20A FOREIGN KEY (user_issuer_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE like_publication ADD CONSTRAINT FK_1CF989F7A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE like_publication ADD CONSTRAINT FK_1CF989F738B217A7 FOREIGN KEY (publication_id) REFERENCES publication (id)');
        $this->addSql('ALTER TABLE user ADD meta_name VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE abonnement');
        $this->addSql('DROP TABLE like_publication');
        $this->addSql('ALTER TABLE `user` DROP meta_name');
    }
}
