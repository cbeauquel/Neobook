<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250315103428 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE key_word (id INT AUTO_INCREMENT NOT NULL, tag VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE key_word_book (key_word_id INT NOT NULL, book_id INT NOT NULL, INDEX IDX_BEB63DA6818167B3 (key_word_id), INDEX IDX_BEB63DA616A2B381 (book_id), PRIMARY KEY(key_word_id, book_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE key_word_book ADD CONSTRAINT FK_BEB63DA6818167B3 FOREIGN KEY (key_word_id) REFERENCES key_word (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE key_word_book ADD CONSTRAINT FK_BEB63DA616A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE key_words_book DROP FOREIGN KEY FK_88B0431E16A2B381');
        $this->addSql('ALTER TABLE key_words_book DROP FOREIGN KEY FK_88B0431EB598DE74');
        $this->addSql('DROP TABLE key_words');
        $this->addSql('DROP TABLE key_words_book');
        $this->addSql('ALTER TABLE user ADD baskets VARCHAR(255) DEFAULT NULL, ADD orders VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE key_words (id INT AUTO_INCREMENT NOT NULL, tag VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE key_words_book (key_words_id INT NOT NULL, book_id INT NOT NULL, INDEX IDX_88B0431EB598DE74 (key_words_id), INDEX IDX_88B0431E16A2B381 (book_id), PRIMARY KEY(key_words_id, book_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE key_words_book ADD CONSTRAINT FK_88B0431E16A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE key_words_book ADD CONSTRAINT FK_88B0431EB598DE74 FOREIGN KEY (key_words_id) REFERENCES key_words (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE key_word_book DROP FOREIGN KEY FK_BEB63DA6818167B3');
        $this->addSql('ALTER TABLE key_word_book DROP FOREIGN KEY FK_BEB63DA616A2B381');
        $this->addSql('DROP TABLE key_word');
        $this->addSql('DROP TABLE key_word_book');
        $this->addSql('ALTER TABLE user DROP baskets, DROP orders');
    }
}
