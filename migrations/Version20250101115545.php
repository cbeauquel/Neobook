<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250101115545 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE feedback (id INT AUTO_INCREMENT NOT NULL, nick_name_id INT NOT NULL, book_id INT DEFAULT NULL, stars INT NOT NULL, comment LONGTEXT DEFAULT NULL, feedback_date DATETIME NOT NULL, INDEX IDX_D229445815B4D30C (nick_name_id), INDEX IDX_D229445816A2B381 (book_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE feedback ADD CONSTRAINT FK_D229445815B4D30C FOREIGN KEY (nick_name_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE feedback ADD CONSTRAINT FK_D229445816A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE book ADD creation_date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE user ADD nick_name VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE feedback DROP FOREIGN KEY FK_D229445815B4D30C');
        $this->addSql('ALTER TABLE feedback DROP FOREIGN KEY FK_D229445816A2B381');
        $this->addSql('DROP TABLE feedback');
        $this->addSql('ALTER TABLE user DROP nick_name');
        $this->addSql('ALTER TABLE book DROP creation_date');
    }
}
