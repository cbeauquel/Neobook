<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260113200734 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sales (id INT AUTO_INCREMENT NOT NULL, format_id INT DEFAULT NULL, sales_start_date DATETIME NOT NULL, sales_end_date DATETIME NOT NULL, reduced_price_ht DOUBLE PRECISION NOT NULL, reduced_price_ttc DOUBLE PRECISION NOT NULL, INDEX IDX_6B817044D629F605 (format_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sales ADD CONSTRAINT FK_6B817044D629F605 FOREIGN KEY (format_id) REFERENCES format (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sales DROP FOREIGN KEY FK_6B817044D629F605');
        $this->addSql('DROP TABLE sales');
    }
}
