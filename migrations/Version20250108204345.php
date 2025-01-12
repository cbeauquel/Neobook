<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250108204345 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bo_sk_co (id INT AUTO_INCREMENT NOT NULL, contributor_id INT NOT NULL, skill_id INT NOT NULL, book_id INT NOT NULL, INDEX IDX_D1A239BC7A19A357 (contributor_id), INDEX IDX_D1A239BC5585C142 (skill_id), INDEX IDX_D1A239BC16A2B381 (book_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bo_sk_co ADD CONSTRAINT FK_D1A239BC7A19A357 FOREIGN KEY (contributor_id) REFERENCES contributor (id)');
        $this->addSql('ALTER TABLE bo_sk_co ADD CONSTRAINT FK_D1A239BC5585C142 FOREIGN KEY (skill_id) REFERENCES skill (id)');
        $this->addSql('ALTER TABLE bo_sk_co ADD CONSTRAINT FK_D1A239BC16A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bo_sk_co DROP FOREIGN KEY FK_D1A239BC7A19A357');
        $this->addSql('ALTER TABLE bo_sk_co DROP FOREIGN KEY FK_D1A239BC5585C142');
        $this->addSql('ALTER TABLE bo_sk_co DROP FOREIGN KEY FK_D1A239BC16A2B381');
        $this->addSql('DROP TABLE bo_sk_co');
    }
}
