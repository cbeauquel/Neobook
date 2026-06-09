<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260113210939 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sale (id INT AUTO_INCREMENT NOT NULL, format_id INT DEFAULT NULL, sales_start_date DATETIME NOT NULL, sales_end_date DATETIME NOT NULL, reduced_price_ht NUMERIC(4, 2) NOT NULL, reduced_price_ttc NUMERIC(4, 2) NOT NULL, INDEX IDX_E54BC005D629F605 (format_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sale ADD CONSTRAINT FK_E54BC005D629F605 FOREIGN KEY (format_id) REFERENCES format (id)');
        $this->addSql('ALTER TABLE sales DROP FOREIGN KEY FK_6B817044D629F605');
        $this->addSql('DROP TABLE sales');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sales (id INT AUTO_INCREMENT NOT NULL, format_id INT DEFAULT NULL, sales_start_date DATETIME NOT NULL, sales_end_date DATETIME NOT NULL, reduced_price_ht DOUBLE PRECISION NOT NULL, reduced_price_ttc DOUBLE PRECISION NOT NULL, INDEX IDX_6B817044D629F605 (format_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE sales ADD CONSTRAINT FK_6B817044D629F605 FOREIGN KEY (format_id) REFERENCES format (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE sale DROP FOREIGN KEY FK_E54BC005D629F605');
        $this->addSql('DROP TABLE sale');
    }
}
