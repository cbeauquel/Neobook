<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250108195038 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE book_skill (book_id INT NOT NULL, skill_id INT NOT NULL, INDEX IDX_50FFF10E16A2B381 (book_id), INDEX IDX_50FFF10E5585C142 (skill_id), PRIMARY KEY(book_id, skill_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE book_skill ADD CONSTRAINT FK_50FFF10E16A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE book_skill ADD CONSTRAINT FK_50FFF10E5585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book_skill DROP FOREIGN KEY FK_50FFF10E16A2B381');
        $this->addSql('ALTER TABLE book_skill DROP FOREIGN KEY FK_50FFF10E5585C142');
        $this->addSql('DROP TABLE book_skill');
    }
}
