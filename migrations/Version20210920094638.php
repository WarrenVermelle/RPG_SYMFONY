<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210920094638 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inventory ADD champ_id INT NOT NULL, ADD item_id INT NOT NULL');
        $this->addSql('ALTER TABLE inventory ADD CONSTRAINT FK_B12D4A36D32AA90E FOREIGN KEY (champ_id) REFERENCES champion (id)');
        $this->addSql('ALTER TABLE inventory ADD CONSTRAINT FK_B12D4A36126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
        $this->addSql('CREATE INDEX IDX_B12D4A36D32AA90E ON inventory (champ_id)');
        $this->addSql('CREATE INDEX IDX_B12D4A36126F525E ON inventory (item_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inventory DROP FOREIGN KEY FK_B12D4A36D32AA90E');
        $this->addSql('ALTER TABLE inventory DROP FOREIGN KEY FK_B12D4A36126F525E');
        $this->addSql('DROP INDEX IDX_B12D4A36D32AA90E ON inventory');
        $this->addSql('DROP INDEX IDX_B12D4A36126F525E ON inventory');
        $this->addSql('ALTER TABLE inventory DROP champ_id, DROP item_id');
    }
}
