<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250315140205 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE basket CHANGE total_ht total_ht NUMERIC(4, 2) NOT NULL, CHANGE total_ttc total_ttc NUMERIC(4, 2) NOT NULL');
        $this->addSql('ALTER TABLE format CHANGE price_ht price_ht NUMERIC(4, 2) NOT NULL, CHANGE price_ttc price_ttc NUMERIC(4, 2) NOT NULL');
        $this->addSql('ALTER TABLE `order` CHANGE total_ht total_ht NUMERIC(4, 2) NOT NULL, CHANGE total_ttc total_ttc NUMERIC(4, 2) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE basket CHANGE total_ht total_ht DOUBLE PRECISION NOT NULL, CHANGE total_ttc total_ttc DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE format CHANGE price_ht price_ht DOUBLE PRECISION NOT NULL, CHANGE price_ttc price_ttc DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE `order` CHANGE total_ht total_ht DOUBLE PRECISION NOT NULL, CHANGE total_ttc total_ttc DOUBLE PRECISION NOT NULL');
    }
}
