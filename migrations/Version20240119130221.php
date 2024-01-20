<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240119130221 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE default_task (id INT AUTO_INCREMENT NOT NULL, check_list_category_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_178FE023BEC4E132 (check_list_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE default_task ADD CONSTRAINT FK_178FE023BEC4E132 FOREIGN KEY (check_list_category_id) REFERENCES check_list_category (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE default_task DROP FOREIGN KEY FK_178FE023BEC4E132');
        $this->addSql('DROP TABLE default_task');
    }
}
