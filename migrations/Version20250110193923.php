<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250110193923 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bo_sk_co_book DROP FOREIGN KEY FK_8C0BFC4416A2B381');
        $this->addSql('ALTER TABLE bo_sk_co_book DROP FOREIGN KEY FK_8C0BFC449C598DEB');
        $this->addSql('ALTER TABLE bo_sk_co_contributor DROP FOREIGN KEY FK_8C0CB077A19A357');
        $this->addSql('ALTER TABLE bo_sk_co_contributor DROP FOREIGN KEY FK_8C0CB079C598DEB');
        $this->addSql('ALTER TABLE bo_sk_co_skill DROP FOREIGN KEY FK_7E158F9B5585C142');
        $this->addSql('ALTER TABLE bo_sk_co_skill DROP FOREIGN KEY FK_7E158F9B9C598DEB');
        $this->addSql('DROP TABLE bo_sk_co_book');
        $this->addSql('DROP TABLE bo_sk_co_contributor');
        $this->addSql('DROP TABLE bo_sk_co_skill');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bo_sk_co_book (bo_sk_co_id INT NOT NULL, book_id INT NOT NULL, INDEX IDX_8C0BFC4416A2B381 (book_id), INDEX IDX_8C0BFC449C598DEB (bo_sk_co_id), PRIMARY KEY(bo_sk_co_id, book_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE bo_sk_co_contributor (bo_sk_co_id INT NOT NULL, contributor_id INT NOT NULL, INDEX IDX_8C0CB077A19A357 (contributor_id), INDEX IDX_8C0CB079C598DEB (bo_sk_co_id), PRIMARY KEY(bo_sk_co_id, contributor_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE bo_sk_co_skill (bo_sk_co_id INT NOT NULL, skill_id INT NOT NULL, INDEX IDX_7E158F9B5585C142 (skill_id), INDEX IDX_7E158F9B9C598DEB (bo_sk_co_id), PRIMARY KEY(bo_sk_co_id, skill_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE bo_sk_co_book ADD CONSTRAINT FK_8C0BFC4416A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bo_sk_co_book ADD CONSTRAINT FK_8C0BFC449C598DEB FOREIGN KEY (bo_sk_co_id) REFERENCES bo_sk_co (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bo_sk_co_contributor ADD CONSTRAINT FK_8C0CB077A19A357 FOREIGN KEY (contributor_id) REFERENCES contributor (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bo_sk_co_contributor ADD CONSTRAINT FK_8C0CB079C598DEB FOREIGN KEY (bo_sk_co_id) REFERENCES bo_sk_co (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bo_sk_co_skill ADD CONSTRAINT FK_7E158F9B5585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bo_sk_co_skill ADD CONSTRAINT FK_7E158F9B9C598DEB FOREIGN KEY (bo_sk_co_id) REFERENCES bo_sk_co (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
