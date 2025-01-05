<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250104104705 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contributor (id INT AUTO_INCREMENT NOT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, bio LONGTEXT NOT NULL, photo VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, date_add DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contributor_book (contributor_id INT NOT NULL, book_id INT NOT NULL, INDEX IDX_18ADF67F7A19A357 (contributor_id), INDEX IDX_18ADF67F16A2B381 (book_id), PRIMARY KEY(contributor_id, book_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contributor_skill (contributor_id INT NOT NULL, skill_id INT NOT NULL, INDEX IDX_CF8AC0B57A19A357 (contributor_id), INDEX IDX_CF8AC0B55585C142 (skill_id), PRIMARY KEY(contributor_id, skill_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contributor_book ADD CONSTRAINT FK_18ADF67F7A19A357 FOREIGN KEY (contributor_id) REFERENCES contributor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contributor_book ADD CONSTRAINT FK_18ADF67F16A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contributor_skill ADD CONSTRAINT FK_CF8AC0B57A19A357 FOREIGN KEY (contributor_id) REFERENCES contributor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contributor_skill ADD CONSTRAINT FK_CF8AC0B55585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE author_book DROP FOREIGN KEY FK_2F0A2BEE16A2B381');
        $this->addSql('ALTER TABLE author_book DROP FOREIGN KEY FK_2F0A2BEEF675F31B');
        $this->addSql('DROP TABLE author');
        $this->addSql('DROP TABLE author_book');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE author (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, surname VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, bio LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, photo VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, status VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date_add DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE author_book (author_id INT NOT NULL, book_id INT NOT NULL, INDEX IDX_2F0A2BEE16A2B381 (book_id), INDEX IDX_2F0A2BEEF675F31B (author_id), PRIMARY KEY(author_id, book_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE author_book ADD CONSTRAINT FK_2F0A2BEE16A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE author_book ADD CONSTRAINT FK_2F0A2BEEF675F31B FOREIGN KEY (author_id) REFERENCES author (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contributor_book DROP FOREIGN KEY FK_18ADF67F7A19A357');
        $this->addSql('ALTER TABLE contributor_book DROP FOREIGN KEY FK_18ADF67F16A2B381');
        $this->addSql('ALTER TABLE contributor_skill DROP FOREIGN KEY FK_CF8AC0B57A19A357');
        $this->addSql('ALTER TABLE contributor_skill DROP FOREIGN KEY FK_CF8AC0B55585C142');
        $this->addSql('DROP TABLE contributor');
        $this->addSql('DROP TABLE contributor_book');
        $this->addSql('DROP TABLE contributor_skill');
        $this->addSql('DROP TABLE skill');
    }
}
