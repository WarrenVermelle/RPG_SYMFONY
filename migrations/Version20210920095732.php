<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210920095732 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE champion ADD player_id INT NOT NULL, ADD race_id INT NOT NULL, ADD faction_id INT NOT NULL');
        $this->addSql('ALTER TABLE champion ADD CONSTRAINT FK_45437EB499E6F5DF FOREIGN KEY (player_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE champion ADD CONSTRAINT FK_45437EB46E59D40D FOREIGN KEY (race_id) REFERENCES race (id)');
        $this->addSql('ALTER TABLE champion ADD CONSTRAINT FK_45437EB44448F8DA FOREIGN KEY (faction_id) REFERENCES faction (id)');
        $this->addSql('CREATE INDEX IDX_45437EB499E6F5DF ON champion (player_id)');
        $this->addSql('CREATE INDEX IDX_45437EB46E59D40D ON champion (race_id)');
        $this->addSql('CREATE INDEX IDX_45437EB44448F8DA ON champion (faction_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE champion DROP FOREIGN KEY FK_45437EB499E6F5DF');
        $this->addSql('ALTER TABLE champion DROP FOREIGN KEY FK_45437EB46E59D40D');
        $this->addSql('ALTER TABLE champion DROP FOREIGN KEY FK_45437EB44448F8DA');
        $this->addSql('DROP INDEX IDX_45437EB499E6F5DF ON champion');
        $this->addSql('DROP INDEX IDX_45437EB46E59D40D ON champion');
        $this->addSql('DROP INDEX IDX_45437EB44448F8DA ON champion');
        $this->addSql('ALTER TABLE champion DROP player_id, DROP race_id, DROP faction_id');
    }
}
