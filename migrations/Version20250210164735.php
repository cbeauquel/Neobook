<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250210164735 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE to_be_read (id INT AUTO_INCREMENT NOT NULL, customer_id_id INT DEFAULT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_54B4E7CFB171EB6C (customer_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE to_be_read ADD CONSTRAINT FK_54B4E7CFB171EB6C FOREIGN KEY (customer_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE book ADD to_be_read_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A331218106A7 FOREIGN KEY (to_be_read_id) REFERENCES to_be_read (id)');
        $this->addSql('CREATE INDEX IDX_CBE5A331218106A7 ON book (to_be_read_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A331218106A7');
        $this->addSql('ALTER TABLE to_be_read DROP FOREIGN KEY FK_54B4E7CFB171EB6C');
        $this->addSql('DROP TABLE to_be_read');
        $this->addSql('DROP INDEX IDX_CBE5A331218106A7 ON book');
        $this->addSql('ALTER TABLE book DROP to_be_read_id');
    }
}
