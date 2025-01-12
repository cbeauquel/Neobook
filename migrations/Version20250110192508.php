<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250110192508 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book_skill DROP FOREIGN KEY FK_50FFF10E16A2B381');
        $this->addSql('ALTER TABLE book_skill DROP FOREIGN KEY FK_50FFF10E5585C142');
        $this->addSql('ALTER TABLE contributor_book DROP FOREIGN KEY FK_18ADF67F16A2B381');
        $this->addSql('ALTER TABLE contributor_book DROP FOREIGN KEY FK_18ADF67F7A19A357');
        $this->addSql('ALTER TABLE contributor_skill DROP FOREIGN KEY FK_CF8AC0B55585C142');
        $this->addSql('ALTER TABLE contributor_skill DROP FOREIGN KEY FK_CF8AC0B57A19A357');
        $this->addSql('DROP TABLE book_skill');
        $this->addSql('DROP TABLE contributor_book');
        $this->addSql('DROP TABLE contributor_skill');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE book_skill (book_id INT NOT NULL, skill_id INT NOT NULL, INDEX IDX_50FFF10E16A2B381 (book_id), INDEX IDX_50FFF10E5585C142 (skill_id), PRIMARY KEY(book_id, skill_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE contributor_book (contributor_id INT NOT NULL, book_id INT NOT NULL, INDEX IDX_18ADF67F16A2B381 (book_id), INDEX IDX_18ADF67F7A19A357 (contributor_id), PRIMARY KEY(contributor_id, book_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE contributor_skill (contributor_id INT NOT NULL, skill_id INT NOT NULL, INDEX IDX_CF8AC0B55585C142 (skill_id), INDEX IDX_CF8AC0B57A19A357 (contributor_id), PRIMARY KEY(contributor_id, skill_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE book_skill ADD CONSTRAINT FK_50FFF10E16A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE book_skill ADD CONSTRAINT FK_50FFF10E5585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contributor_book ADD CONSTRAINT FK_18ADF67F16A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contributor_book ADD CONSTRAINT FK_18ADF67F7A19A357 FOREIGN KEY (contributor_id) REFERENCES contributor (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contributor_skill ADD CONSTRAINT FK_CF8AC0B55585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contributor_skill ADD CONSTRAINT FK_CF8AC0B57A19A357 FOREIGN KEY (contributor_id) REFERENCES contributor (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
