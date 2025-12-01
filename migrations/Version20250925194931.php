<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250925194931 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE download_link (id INT AUTO_INCREMENT NOT NULL, customer_id INT NOT NULL, format_id INT NOT NULL, order_id INT NOT NULL, token VARCHAR(64) NOT NULL, download_count INT NOT NULL, max_downloads INT NOT NULL, expires_at DATETIME DEFAULT NULL, is_active TINYINT(1) NOT NULL, last_download_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_235CA2CD5F37A13B (token), INDEX IDX_235CA2CD9395C3F3 (customer_id), INDEX IDX_235CA2CDD629F605 (format_id), INDEX IDX_235CA2CD8D9F6D38 (order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE download_link ADD CONSTRAINT FK_235CA2CD9395C3F3 FOREIGN KEY (customer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE download_link ADD CONSTRAINT FK_235CA2CDD629F605 FOREIGN KEY (format_id) REFERENCES format (id)');
        $this->addSql('ALTER TABLE download_link ADD CONSTRAINT FK_235CA2CD8D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE download_link DROP FOREIGN KEY FK_235CA2CD9395C3F3');
        $this->addSql('ALTER TABLE download_link DROP FOREIGN KEY FK_235CA2CDD629F605');
        $this->addSql('ALTER TABLE download_link DROP FOREIGN KEY FK_235CA2CD8D9F6D38');
        $this->addSql('DROP TABLE download_link');
    }
}
