<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250101121451 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE download ADD oder_download_id INT NOT NULL');
        $this->addSql('ALTER TABLE download ADD CONSTRAINT FK_781A8270A28B73D9 FOREIGN KEY (oder_download_id) REFERENCES `order` (id)');
        $this->addSql('CREATE INDEX IDX_781A8270A28B73D9 ON download (oder_download_id)');
        $this->addSql('ALTER TABLE `order` ADD status_id INT NOT NULL, ADD payment_mode_id INT NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993986BF700BD FOREIGN KEY (status_id) REFERENCES order_status (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993986EAC8BA0 FOREIGN KEY (payment_mode_id) REFERENCES payment (id)');
        $this->addSql('CREATE INDEX IDX_F52993986BF700BD ON `order` (status_id)');
        $this->addSql('CREATE INDEX IDX_F52993986EAC8BA0 ON `order` (payment_mode_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE download DROP FOREIGN KEY FK_781A8270A28B73D9');
        $this->addSql('DROP INDEX IDX_781A8270A28B73D9 ON download');
        $this->addSql('ALTER TABLE download DROP oder_download_id');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993986BF700BD');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993986EAC8BA0');
        $this->addSql('DROP INDEX IDX_F52993986BF700BD ON `order`');
        $this->addSql('DROP INDEX IDX_F52993986EAC8BA0 ON `order`');
        $this->addSql('ALTER TABLE `order` DROP status_id, DROP payment_mode_id');
    }
}
