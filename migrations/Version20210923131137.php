<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210923131137 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE champion ADD actif TINYINT(1) NOT NULL, ADD max_hp INT NOT NULL, ADD max_mp INT NOT NULL, CHANGE player_id player_id INT NOT NULL, CHANGE race_id race_id INT NOT NULL, CHANGE faction_id faction_id INT NOT NULL, CHANGE img img LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE item ADD price INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE champion DROP actif, DROP max_hp, DROP max_mp, CHANGE player_id player_id INT DEFAULT NULL, CHANGE race_id race_id INT DEFAULT NULL, CHANGE faction_id faction_id INT DEFAULT NULL, CHANGE img img LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE item DROP price');
    }
}
