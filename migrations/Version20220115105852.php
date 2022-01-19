<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220115105852 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE products CHANGE user_add user_add_id INT NOT NULL');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5A56CECB9A FOREIGN KEY (user_add_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_B3BA5A5A56CECB9A ON products (user_add_id)');
        $this->addSql('ALTER TABLE users DROP products, CHANGE action action enum(\'admin\', \'manager\', \'salesman\', \'customer\')');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE products DROP FOREIGN KEY FK_B3BA5A5A56CECB9A');
        $this->addSql('DROP INDEX IDX_B3BA5A5A56CECB9A ON products');
        $this->addSql('ALTER TABLE products CHANGE user_add_id user_add INT NOT NULL');
        $this->addSql('ALTER TABLE users ADD products INT NOT NULL, CHANGE action action VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
