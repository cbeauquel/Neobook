<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250219214348 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE basket (id INT AUTO_INCREMENT NOT NULL, customer_id INT DEFAULT NULL, user_token VARCHAR(255) DEFAULT NULL, total_ht DOUBLE PRECISION NOT NULL, total_ttc DOUBLE PRECISION NOT NULL, status VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_2246507B9395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE basket_format (basket_id INT NOT NULL, format_id INT NOT NULL, INDEX IDX_18E0D3261BE1FB52 (basket_id), INDEX IDX_18E0D326D629F605 (format_id), PRIMARY KEY(basket_id, format_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bo_sk_co (id INT AUTO_INCREMENT NOT NULL, book_id INT NOT NULL, contributor_id INT NOT NULL, skill_id INT NOT NULL, INDEX IDX_D1A239BC16A2B381 (book_id), INDEX IDX_D1A239BC7A19A357 (contributor_id), INDEX IDX_D1A239BC5585C142 (skill_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE book (id INT AUTO_INCREMENT NOT NULL, editor_id INT NOT NULL, title VARCHAR(255) NOT NULL, cover VARCHAR(255) NOT NULL, summary LONGTEXT NOT NULL, genre VARCHAR(255) NOT NULL, parution_date DATE NOT NULL, status TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_CBE5A3316995AC4C (editor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE book_format (book_id INT NOT NULL, format_id INT NOT NULL, INDEX IDX_F76D795216A2B381 (book_id), INDEX IDX_F76D7952D629F605 (format_id), PRIMARY KEY(book_id, format_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_book (category_id INT NOT NULL, book_id INT NOT NULL, INDEX IDX_407ED97612469DE2 (category_id), INDEX IDX_407ED97616A2B381 (book_id), PRIMARY KEY(category_id, book_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contributor (id INT AUTO_INCREMENT NOT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, bio LONGTEXT NOT NULL, photo VARCHAR(255) NOT NULL, status TINYINT(1) NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE download (id INT AUTO_INCREMENT NOT NULL, oder_download_id INT NOT NULL, expiration_date DATETIME NOT NULL, download_url VARCHAR(255) NOT NULL, download_count INT NOT NULL, max_attempts INT NOT NULL, INDEX IDX_781A8270A28B73D9 (oder_download_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE editor (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, logo VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, status TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE feedback (id INT AUTO_INCREMENT NOT NULL, nick_name_id INT NOT NULL, book_id INT DEFAULT NULL, stars INT NOT NULL, comment LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_D229445815B4D30C (nick_name_id), INDEX IDX_D229445816A2B381 (book_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE format (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, tva_rate_id INT NOT NULL, isbn VARCHAR(13) NOT NULL, price_ht DOUBLE PRECISION NOT NULL, duration INT NOT NULL, words_count INT NOT NULL, pages_count INT NOT NULL, file_size DOUBLE PRECISION NOT NULL, file_path VARCHAR(255) NOT NULL, book_extract VARCHAR(255) DEFAULT NULL, price_ttc DOUBLE PRECISION NOT NULL, INDEX IDX_DEBA72DFC54C8C93 (type_id), INDEX IDX_DEBA72DF38C0512E (tva_rate_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE key_words (id INT AUTO_INCREMENT NOT NULL, tag VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE key_words_book (key_words_id INT NOT NULL, book_id INT NOT NULL, INDEX IDX_88B0431EB598DE74 (key_words_id), INDEX IDX_88B0431E16A2B381 (book_id), PRIMARY KEY(key_words_id, book_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, customer_id INT DEFAULT NULL, status_id INT NOT NULL, payment_mode_id INT DEFAULT NULL, basket_id INT NOT NULL, user_token_id INT DEFAULT NULL, new_customer TINYINT(1) NOT NULL, total_ht DOUBLE PRECISION NOT NULL, total_ttc DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_F52993989395C3F3 (customer_id), INDEX IDX_F52993986BF700BD (status_id), INDEX IDX_F52993986EAC8BA0 (payment_mode_id), UNIQUE INDEX UNIQ_F52993981BE1FB52 (basket_id), UNIQUE INDEX UNIQ_F5299398A15303B9 (user_token_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_status (id INT AUTO_INCREMENT NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, mode VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE to_be_read (id INT AUTO_INCREMENT NOT NULL, customer_id INT DEFAULT NULL, book_id INT DEFAULT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_54B4E7CF9395C3F3 (customer_id), INDEX IDX_54B4E7CF16A2B381 (book_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tva (id INT AUTO_INCREMENT NOT NULL, taux DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, type_img VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, last_visit_date DATETIME NOT NULL, opt_in TINYINT(1) NOT NULL, preference VARCHAR(255) DEFAULT NULL, nickname VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE basket ADD CONSTRAINT FK_2246507B9395C3F3 FOREIGN KEY (customer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE basket_format ADD CONSTRAINT FK_18E0D3261BE1FB52 FOREIGN KEY (basket_id) REFERENCES basket (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE basket_format ADD CONSTRAINT FK_18E0D326D629F605 FOREIGN KEY (format_id) REFERENCES format (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bo_sk_co ADD CONSTRAINT FK_D1A239BC16A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE bo_sk_co ADD CONSTRAINT FK_D1A239BC7A19A357 FOREIGN KEY (contributor_id) REFERENCES contributor (id)');
        $this->addSql('ALTER TABLE bo_sk_co ADD CONSTRAINT FK_D1A239BC5585C142 FOREIGN KEY (skill_id) REFERENCES skill (id)');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A3316995AC4C FOREIGN KEY (editor_id) REFERENCES editor (id)');
        $this->addSql('ALTER TABLE book_format ADD CONSTRAINT FK_F76D795216A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE book_format ADD CONSTRAINT FK_F76D7952D629F605 FOREIGN KEY (format_id) REFERENCES format (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_book ADD CONSTRAINT FK_407ED97612469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_book ADD CONSTRAINT FK_407ED97616A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE download ADD CONSTRAINT FK_781A8270A28B73D9 FOREIGN KEY (oder_download_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE feedback ADD CONSTRAINT FK_D229445815B4D30C FOREIGN KEY (nick_name_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE feedback ADD CONSTRAINT FK_D229445816A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE format ADD CONSTRAINT FK_DEBA72DFC54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE format ADD CONSTRAINT FK_DEBA72DF38C0512E FOREIGN KEY (tva_rate_id) REFERENCES tva (id)');
        $this->addSql('ALTER TABLE key_words_book ADD CONSTRAINT FK_88B0431EB598DE74 FOREIGN KEY (key_words_id) REFERENCES key_words (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE key_words_book ADD CONSTRAINT FK_88B0431E16A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993989395C3F3 FOREIGN KEY (customer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993986BF700BD FOREIGN KEY (status_id) REFERENCES order_status (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993986EAC8BA0 FOREIGN KEY (payment_mode_id) REFERENCES payment (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993981BE1FB52 FOREIGN KEY (basket_id) REFERENCES basket (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A15303B9 FOREIGN KEY (user_token_id) REFERENCES basket (id)');
        $this->addSql('ALTER TABLE to_be_read ADD CONSTRAINT FK_54B4E7CF9395C3F3 FOREIGN KEY (customer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE to_be_read ADD CONSTRAINT FK_54B4E7CF16A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE basket DROP FOREIGN KEY FK_2246507B9395C3F3');
        $this->addSql('ALTER TABLE basket_format DROP FOREIGN KEY FK_18E0D3261BE1FB52');
        $this->addSql('ALTER TABLE basket_format DROP FOREIGN KEY FK_18E0D326D629F605');
        $this->addSql('ALTER TABLE bo_sk_co DROP FOREIGN KEY FK_D1A239BC16A2B381');
        $this->addSql('ALTER TABLE bo_sk_co DROP FOREIGN KEY FK_D1A239BC7A19A357');
        $this->addSql('ALTER TABLE bo_sk_co DROP FOREIGN KEY FK_D1A239BC5585C142');
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A3316995AC4C');
        $this->addSql('ALTER TABLE book_format DROP FOREIGN KEY FK_F76D795216A2B381');
        $this->addSql('ALTER TABLE book_format DROP FOREIGN KEY FK_F76D7952D629F605');
        $this->addSql('ALTER TABLE category_book DROP FOREIGN KEY FK_407ED97612469DE2');
        $this->addSql('ALTER TABLE category_book DROP FOREIGN KEY FK_407ED97616A2B381');
        $this->addSql('ALTER TABLE download DROP FOREIGN KEY FK_781A8270A28B73D9');
        $this->addSql('ALTER TABLE feedback DROP FOREIGN KEY FK_D229445815B4D30C');
        $this->addSql('ALTER TABLE feedback DROP FOREIGN KEY FK_D229445816A2B381');
        $this->addSql('ALTER TABLE format DROP FOREIGN KEY FK_DEBA72DFC54C8C93');
        $this->addSql('ALTER TABLE format DROP FOREIGN KEY FK_DEBA72DF38C0512E');
        $this->addSql('ALTER TABLE key_words_book DROP FOREIGN KEY FK_88B0431EB598DE74');
        $this->addSql('ALTER TABLE key_words_book DROP FOREIGN KEY FK_88B0431E16A2B381');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993989395C3F3');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993986BF700BD');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993986EAC8BA0');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993981BE1FB52');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398A15303B9');
        $this->addSql('ALTER TABLE to_be_read DROP FOREIGN KEY FK_54B4E7CF9395C3F3');
        $this->addSql('ALTER TABLE to_be_read DROP FOREIGN KEY FK_54B4E7CF16A2B381');
        $this->addSql('DROP TABLE basket');
        $this->addSql('DROP TABLE basket_format');
        $this->addSql('DROP TABLE bo_sk_co');
        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE book_format');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE category_book');
        $this->addSql('DROP TABLE contributor');
        $this->addSql('DROP TABLE download');
        $this->addSql('DROP TABLE editor');
        $this->addSql('DROP TABLE feedback');
        $this->addSql('DROP TABLE format');
        $this->addSql('DROP TABLE key_words');
        $this->addSql('DROP TABLE key_words_book');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE order_status');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE skill');
        $this->addSql('DROP TABLE to_be_read');
        $this->addSql('DROP TABLE tva');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
