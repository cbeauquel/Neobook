<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250125222716 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE basket_format (basket_id INT NOT NULL, format_id INT NOT NULL, INDEX IDX_18E0D3261BE1FB52 (basket_id), INDEX IDX_18E0D326D629F605 (format_id), PRIMARY KEY(basket_id, format_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE basket_format ADD CONSTRAINT FK_18E0D3261BE1FB52 FOREIGN KEY (basket_id) REFERENCES basket (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE basket_format ADD CONSTRAINT FK_18E0D326D629F605 FOREIGN KEY (format_id) REFERENCES format (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE basket_format DROP FOREIGN KEY FK_18E0D3261BE1FB52');
        $this->addSql('ALTER TABLE basket_format DROP FOREIGN KEY FK_18E0D326D629F605');
        $this->addSql('DROP TABLE basket_format');
    }
}
