<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250318201336 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE download DROP FOREIGN KEY FK_781A8270A28B73D9');
        $this->addSql('DROP INDEX IDX_781A8270A28B73D9 ON download');
        $this->addSql('ALTER TABLE download DROP oder_download_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE download ADD oder_download_id INT NOT NULL');
        $this->addSql('ALTER TABLE download ADD CONSTRAINT FK_781A8270A28B73D9 FOREIGN KEY (oder_download_id) REFERENCES `order` (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_781A8270A28B73D9 ON download (oder_download_id)');
    }
}
