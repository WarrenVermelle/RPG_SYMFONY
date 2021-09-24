<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
<<<<<<< HEAD:migrations/Version20210923115121.php
final class Version20210923115121 extends AbstractMigration
=======
final class Version20210924073350 extends AbstractMigration
>>>>>>> 24090e1a0b3435a71efb38b4eee1668da65dae9b:migrations/Version20210924073350.php
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE champion ADD max_hp INT NOT NULL, ADD max_mp INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE champion DROP max_hp, DROP max_mp');
    }
}
