<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210920101010 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE champion (id INT AUTO_INCREMENT NOT NULL, player_id INT NOT NULL, race_id INT NOT NULL, faction_id INT NOT NULL, name VARCHAR(255) NOT NULL, gender SMALLINT NOT NULL, img LONGTEXT NOT NULL, level INT NOT NULL, gold INT NOT NULL, hp INT NOT NULL, mp INT NOT NULL, intel INT NOT NULL, strength INT NOT NULL, agi INT NOT NULL, INDEX IDX_45437EB499E6F5DF (player_id), INDEX IDX_45437EB46E59D40D (race_id), INDEX IDX_45437EB44448F8DA (faction_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE faction (id INT AUTO_INCREMENT NOT NULL, faction VARCHAR(255) NOT NULL, coef_hp DOUBLE PRECISION NOT NULL, coef_mp DOUBLE PRECISION NOT NULL, coef_intel DOUBLE PRECISION NOT NULL, coef_strength DOUBLE PRECISION NOT NULL, coef_agi DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inventory (id INT AUTO_INCREMENT NOT NULL, champ_id INT NOT NULL, item_id INT NOT NULL, equiped TINYINT(1) NOT NULL, INDEX IDX_B12D4A36D32AA90E (champ_id), INDEX IDX_B12D4A36126F525E (item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, item VARCHAR(255) NOT NULL, img LONGTEXT NOT NULL, hp INT NOT NULL, mp INT NOT NULL, intel INT NOT NULL, strength INT NOT NULL, agi INT NOT NULL, INDEX IDX_1F1B251EC54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE monster (id INT AUTO_INCREMENT NOT NULL, monster VARCHAR(255) NOT NULL, level INT NOT NULL, hp INT NOT NULL, mp INT NOT NULL, intel INT NOT NULL, strength INT NOT NULL, agi INT NOT NULL, gold INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE race (id INT AUTO_INCREMENT NOT NULL, race VARCHAR(255) NOT NULL, ratio_hp DOUBLE PRECISION NOT NULL, ratio_mp DOUBLE PRECISION NOT NULL, ratio_intel DOUBLE PRECISION NOT NULL, ratio_strength DOUBLE PRECISION NOT NULL, ratio_agi DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE champion ADD CONSTRAINT FK_45437EB499E6F5DF FOREIGN KEY (player_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE champion ADD CONSTRAINT FK_45437EB46E59D40D FOREIGN KEY (race_id) REFERENCES race (id)');
        $this->addSql('ALTER TABLE champion ADD CONSTRAINT FK_45437EB44448F8DA FOREIGN KEY (faction_id) REFERENCES faction (id)');
        $this->addSql('ALTER TABLE inventory ADD CONSTRAINT FK_B12D4A36D32AA90E FOREIGN KEY (champ_id) REFERENCES champion (id)');
        $this->addSql('ALTER TABLE inventory ADD CONSTRAINT FK_B12D4A36126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251EC54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inventory DROP FOREIGN KEY FK_B12D4A36D32AA90E');
        $this->addSql('ALTER TABLE champion DROP FOREIGN KEY FK_45437EB44448F8DA');
        $this->addSql('ALTER TABLE inventory DROP FOREIGN KEY FK_B12D4A36126F525E');
        $this->addSql('ALTER TABLE champion DROP FOREIGN KEY FK_45437EB46E59D40D');
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251EC54C8C93');
        $this->addSql('ALTER TABLE champion DROP FOREIGN KEY FK_45437EB499E6F5DF');
        $this->addSql('DROP TABLE champion');
        $this->addSql('DROP TABLE faction');
        $this->addSql('DROP TABLE inventory');
        $this->addSql('DROP TABLE item');
        $this->addSql('DROP TABLE monster');
        $this->addSql('DROP TABLE race');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE user');
    }
}
