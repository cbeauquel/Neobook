<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250210202902 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A331218106A7');
        $this->addSql('DROP INDEX IDX_CBE5A331218106A7 ON book');
        $this->addSql('ALTER TABLE book DROP to_be_read_id');
        $this->addSql('ALTER TABLE to_be_read DROP FOREIGN KEY FK_54B4E7CFB171EB6C');
        $this->addSql('DROP INDEX IDX_54B4E7CFB171EB6C ON to_be_read');
        $this->addSql('ALTER TABLE to_be_read ADD book_id INT DEFAULT NULL, CHANGE customer_id_id customer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE to_be_read ADD CONSTRAINT FK_54B4E7CF9395C3F3 FOREIGN KEY (customer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE to_be_read ADD CONSTRAINT FK_54B4E7CF16A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('CREATE INDEX IDX_54B4E7CF9395C3F3 ON to_be_read (customer_id)');
        $this->addSql('CREATE INDEX IDX_54B4E7CF16A2B381 ON to_be_read (book_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book ADD to_be_read_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A331218106A7 FOREIGN KEY (to_be_read_id) REFERENCES to_be_read (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_CBE5A331218106A7 ON book (to_be_read_id)');
        $this->addSql('ALTER TABLE to_be_read DROP FOREIGN KEY FK_54B4E7CF9395C3F3');
        $this->addSql('ALTER TABLE to_be_read DROP FOREIGN KEY FK_54B4E7CF16A2B381');
        $this->addSql('DROP INDEX IDX_54B4E7CF9395C3F3 ON to_be_read');
        $this->addSql('DROP INDEX IDX_54B4E7CF16A2B381 ON to_be_read');
        $this->addSql('ALTER TABLE to_be_read ADD customer_id_id INT DEFAULT NULL, DROP customer_id, DROP book_id');
        $this->addSql('ALTER TABLE to_be_read ADD CONSTRAINT FK_54B4E7CFB171EB6C FOREIGN KEY (customer_id_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_54B4E7CFB171EB6C ON to_be_read (customer_id_id)');
    }
}
