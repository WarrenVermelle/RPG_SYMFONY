<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210924114757 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE champion CHANGE player_id player_id INT NOT NULL, CHANGE race_id race_id INT NOT NULL, CHANGE faction_id faction_id INT NOT NULL, CHANGE img img LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE monster ADD hp_max INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE champion CHANGE player_id player_id INT DEFAULT NULL, CHANGE race_id race_id INT DEFAULT NULL, CHANGE faction_id faction_id INT DEFAULT NULL, CHANGE img img LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE monster DROP hp_max');
    }
}
