<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240120124745 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE budget_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, expense_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE default_expenses (id INT AUTO_INCREMENT NOT NULL, budget_category_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_22D2C315644CDBBD (budget_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE default_expenses ADD CONSTRAINT FK_22D2C315644CDBBD FOREIGN KEY (budget_category_id) REFERENCES budget_category (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE default_expenses DROP FOREIGN KEY FK_22D2C315644CDBBD');
        $this->addSql('DROP TABLE budget_category');
        $this->addSql('DROP TABLE default_expenses');
    }
}
