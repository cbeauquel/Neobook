<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250104213447 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contributor ADD CONSTRAINT FK_DA6F97935585C142 FOREIGN KEY (skill_id) REFERENCES skill (id)');
        $this->addSql('ALTER TABLE contributor RENAME INDEX skill_id TO IDX_DA6F97935585C142');
        $this->addSql('ALTER TABLE format DROP type, DROP type_img');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contributor DROP FOREIGN KEY FK_DA6F97935585C142');
        $this->addSql('ALTER TABLE contributor RENAME INDEX idx_da6f97935585c142 TO skill_id');
        $this->addSql('ALTER TABLE format ADD type VARCHAR(255) NOT NULL, ADD type_img VARCHAR(255) DEFAULT NULL');
    }
}
