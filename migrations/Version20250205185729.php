<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250205185729 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` ADD user_token_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A15303B9 FOREIGN KEY (user_token_id) REFERENCES basket (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F5299398A15303B9 ON `order` (user_token_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398A15303B9');
        $this->addSql('DROP INDEX UNIQ_F5299398A15303B9 ON `order`');
        $this->addSql('ALTER TABLE `order` DROP user_token_id');
    }
}
