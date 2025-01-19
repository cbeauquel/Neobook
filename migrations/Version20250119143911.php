<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250119143911 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE basket CHANGE date created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE book ADD update_at DATETIME NOT NULL, ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL, DROP book_update, DROP creation_date');
        $this->addSql('ALTER TABLE contributor ADD updated_at DATETIME NOT NULL, CHANGE date_add created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE editor ADD updated_at DATETIME NOT NULL, CHANGE date_add created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE feedback ADD updated_at DATETIME NOT NULL, CHANGE feedback_date created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD updated_at DATETIME NOT NULL, CHANGE order_date created_at DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE basket CHANGE created_at date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE book ADD book_update DATETIME NOT NULL, ADD creation_date DATETIME NOT NULL, DROP update_at, DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE contributor ADD date_add DATETIME NOT NULL, DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE editor ADD date_add DATETIME NOT NULL, DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE feedback ADD feedback_date DATETIME NOT NULL, DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE `order` ADD order_date DATETIME NOT NULL, DROP created_at, DROP updated_at');
    }
}
