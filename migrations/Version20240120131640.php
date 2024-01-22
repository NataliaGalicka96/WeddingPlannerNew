<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240120131640 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE expenses (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, budget_category_id INT DEFAULT NULL, expense VARCHAR(255) NOT NULL, price NUMERIC(10, 2) DEFAULT NULL, already_paid NUMERIC(10, 2) DEFAULT NULL, INDEX IDX_2496F35BA76ED395 (user_id), INDEX IDX_2496F35B644CDBBD (budget_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE expenses ADD CONSTRAINT FK_2496F35BA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE expenses ADD CONSTRAINT FK_2496F35B644CDBBD FOREIGN KEY (budget_category_id) REFERENCES budget_category (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE expenses DROP FOREIGN KEY FK_2496F35BA76ED395');
        $this->addSql('ALTER TABLE expenses DROP FOREIGN KEY FK_2496F35B644CDBBD');
        $this->addSql('DROP TABLE expenses');
    }
}
