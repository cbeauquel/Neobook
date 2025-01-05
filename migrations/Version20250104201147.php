<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250104201147 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bo_co_si DROP FOREIGN KEY FK_9D818E0D16A2B381');
        $this->addSql('ALTER TABLE bo_co_si DROP FOREIGN KEY FK_9D818E0D5585C142');
        $this->addSql('ALTER TABLE bo_co_si DROP FOREIGN KEY FK_9D818E0D7A19A357');
        $this->addSql('DROP TABLE bo_co_si');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bo_co_si (id INT AUTO_INCREMENT NOT NULL, book_id INT NOT NULL, contributor_id INT NOT NULL, skill_id INT NOT NULL, INDEX IDX_9D818E0D16A2B381 (book_id), INDEX IDX_9D818E0D7A19A357 (contributor_id), INDEX IDX_9D818E0D5585C142 (skill_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE bo_co_si ADD CONSTRAINT FK_9D818E0D16A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE bo_co_si ADD CONSTRAINT FK_9D818E0D5585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE bo_co_si ADD CONSTRAINT FK_9D818E0D7A19A357 FOREIGN KEY (contributor_id) REFERENCES contributor (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
