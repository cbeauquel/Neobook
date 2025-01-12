<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250107211015 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contributor_skill (contributor_id INT NOT NULL, skill_id INT NOT NULL, INDEX IDX_CF8AC0B57A19A357 (contributor_id), INDEX IDX_CF8AC0B55585C142 (skill_id), PRIMARY KEY(contributor_id, skill_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contributor_skill ADD CONSTRAINT FK_CF8AC0B57A19A357 FOREIGN KEY (contributor_id) REFERENCES contributor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contributor_skill ADD CONSTRAINT FK_CF8AC0B55585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contributor_skill DROP FOREIGN KEY FK_CF8AC0B57A19A357');
        $this->addSql('ALTER TABLE contributor_skill DROP FOREIGN KEY FK_CF8AC0B55585C142');
        $this->addSql('DROP TABLE contributor_skill');
    }
}
