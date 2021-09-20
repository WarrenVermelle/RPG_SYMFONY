<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210920082902 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE champion (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, gender SMALLINT NOT NULL, img LONGTEXT NOT NULL, level INT NOT NULL, gold INT NOT NULL, hp INT NOT NULL, mp INT NOT NULL, intel INT NOT NULL, strength INT NOT NULL, agi INT NOT NULL, id_player INT NOT NULL, id_race INT NOT NULL, id_class INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE faction (id INT AUTO_INCREMENT NOT NULL, faction VARCHAR(255) NOT NULL, coef_hp DOUBLE PRECISION NOT NULL, coef_mp DOUBLE PRECISION NOT NULL, coef_intel DOUBLE PRECISION NOT NULL, coef_strength DOUBLE PRECISION NOT NULL, coef_agi DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inventory (id INT AUTO_INCREMENT NOT NULL, id_champ INT NOT NULL, id_object INT NOT NULL, equiped TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item (id INT AUTO_INCREMENT NOT NULL, item VARCHAR(255) NOT NULL, img LONGTEXT NOT NULL, hp INT NOT NULL, mp INT NOT NULL, intel INT NOT NULL, strength INT NOT NULL, agi INT NOT NULL, id_type INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE monster (id INT AUTO_INCREMENT NOT NULL, monster VARCHAR(255) NOT NULL, level INT NOT NULL, hp INT NOT NULL, mp INT NOT NULL, intel INT NOT NULL, strength INT NOT NULL, agi INT NOT NULL, gold INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE race (id INT AUTO_INCREMENT NOT NULL, race VARCHAR(255) NOT NULL, ratio_hp DOUBLE PRECISION NOT NULL, ratio_mp DOUBLE PRECISION NOT NULL, ratio_intel DOUBLE PRECISION NOT NULL, ratio_strength DOUBLE PRECISION NOT NULL, ratio_agi DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE champion');
        $this->addSql('DROP TABLE faction');
        $this->addSql('DROP TABLE inventory');
        $this->addSql('DROP TABLE item');
        $this->addSql('DROP TABLE monster');
        $this->addSql('DROP TABLE race');
        $this->addSql('DROP TABLE type');
    }
}
