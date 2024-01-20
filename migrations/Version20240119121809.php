<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240119121809 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE check_list ADD check_list_category_id INT NOT NULL');
        $this->addSql('ALTER TABLE check_list ADD CONSTRAINT FK_A1488C99BEC4E132 FOREIGN KEY (check_list_category_id) REFERENCES check_list_category (id)');
        $this->addSql('CREATE INDEX IDX_A1488C99BEC4E132 ON check_list (check_list_category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE check_list DROP FOREIGN KEY FK_A1488C99BEC4E132');
        $this->addSql('DROP INDEX IDX_A1488C99BEC4E132 ON check_list');
        $this->addSql('ALTER TABLE check_list DROP check_list_category_id');
    }
}
