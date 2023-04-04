<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230401035621 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE blog (id INT AUTO_INCREMENT NOT NULL, introduction VARCHAR(255) DEFAULT NULL, definition VARCHAR(255) DEFAULT NULL, signes_cliniques VARCHAR(255) DEFAULT NULL, examens VARCHAR(255) DEFAULT NULL, complementaires VARCHAR(255) DEFAULT NULL, diagnostic VARCHAR(255) DEFAULT NULL, pronostic_evaluation VARCHAR(255) DEFAULT NULL, prise_en_charge VARCHAR(255) DEFAULT NULL, points_cles VARCHAR(255) DEFAULT NULL, diagnostic_difficile VARCHAR(255) DEFAULT NULL, cat VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, date_article VARCHAR(255) DEFAULT NULL, id_user VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user CHANGE avatar avatar VARCHAR(255) NOT NULL, CHANGE date_creation date_creation VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE blog');
        $this->addSql('ALTER TABLE user CHANGE avatar avatar VARCHAR(255) DEFAULT NULL, CHANGE date_creation date_creation VARCHAR(255) DEFAULT NULL');
    }
}
