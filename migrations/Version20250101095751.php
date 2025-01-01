<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250101095751 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE book_format (book_id INT NOT NULL, format_id INT NOT NULL, INDEX IDX_F76D795216A2B381 (book_id), INDEX IDX_F76D7952D629F605 (format_id), PRIMARY KEY(book_id, format_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE book_format ADD CONSTRAINT FK_F76D795216A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE book_format ADD CONSTRAINT FK_F76D7952D629F605 FOREIGN KEY (format_id) REFERENCES format (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book_format DROP FOREIGN KEY FK_F76D795216A2B381');
        $this->addSql('ALTER TABLE book_format DROP FOREIGN KEY FK_F76D7952D629F605');
        $this->addSql('DROP TABLE book_format');
    }
}
