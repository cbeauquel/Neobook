<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250110193130 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bo_sk_co DROP FOREIGN KEY FK_D1A239BC16A2B381');
        $this->addSql('ALTER TABLE bo_sk_co DROP FOREIGN KEY FK_D1A239BC5585C142');
        $this->addSql('ALTER TABLE bo_sk_co DROP FOREIGN KEY FK_D1A239BC7A19A357');
        $this->addSql('DROP INDEX IDX_D1A239BC16A2B381 ON bo_sk_co');
        $this->addSql('DROP INDEX IDX_D1A239BC5585C142 ON bo_sk_co');
        $this->addSql('DROP INDEX IDX_D1A239BC7A19A357 ON bo_sk_co');
        $this->addSql('ALTER TABLE bo_sk_co DROP contributor_id, DROP skill_id, DROP book_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bo_sk_co ADD contributor_id INT NOT NULL, ADD skill_id INT NOT NULL, ADD book_id INT NOT NULL');
        $this->addSql('ALTER TABLE bo_sk_co ADD CONSTRAINT FK_D1A239BC16A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE bo_sk_co ADD CONSTRAINT FK_D1A239BC5585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE bo_sk_co ADD CONSTRAINT FK_D1A239BC7A19A357 FOREIGN KEY (contributor_id) REFERENCES contributor (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_D1A239BC16A2B381 ON bo_sk_co (book_id)');
        $this->addSql('CREATE INDEX IDX_D1A239BC5585C142 ON bo_sk_co (skill_id)');
        $this->addSql('CREATE INDEX IDX_D1A239BC7A19A357 ON bo_sk_co (contributor_id)');
    }
}
