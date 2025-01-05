<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250104215048 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE format ADD CONSTRAINT FK_DEBA72DFC54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('CREATE INDEX IDX_DEBA72DFC54C8C93 ON format (type_id)');
        $this->addSql('ALTER TABLE type ADD name VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE format DROP FOREIGN KEY FK_DEBA72DFC54C8C93');
        $this->addSql('DROP INDEX IDX_DEBA72DFC54C8C93 ON format');
        $this->addSql('ALTER TABLE type DROP name');
    }
}
