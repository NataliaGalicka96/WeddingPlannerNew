<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240123043851 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE guest (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, is_confirmed TINYINT(1) DEFAULT NULL, is_accommodation TINYINT(1) DEFAULT NULL, transport TINYINT(1) DEFAULT NULL, is_adult TINYINT(1) DEFAULT NULL, is_child_under_three_years TINYINT(1) DEFAULT NULL, is_child_between_three_and_twelve TINYINT(1) DEFAULT NULL, special_diet TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE guest');
    }
}
