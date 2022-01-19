<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220114212337 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE products (id INT AUTO_INCREMENT NOT NULL, user_add_id INT NOT NULL, name VARCHAR(50) NOT NULL, maker VARCHAR(100) NOT NULL, price INT NOT NULL, date_create DATE NOT NULL, date_update DATE DEFAULT NULL, description LONGTEXT DEFAULT NULL, summ INT NOT NULL, INDEX IDX_B3BA5A5A56CECB9A (user_add_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(100) NOT NULL, name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, action VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5A56CECB9A FOREIGN KEY (user_add_id) REFERENCES users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE products DROP FOREIGN KEY FK_B3BA5A5A56CECB9A');
        $this->addSql('DROP TABLE products');
        $this->addSql('DROP TABLE users');
    }
}
