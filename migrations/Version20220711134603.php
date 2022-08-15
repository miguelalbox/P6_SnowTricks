<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220711134603 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE figures ADD media_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE figures ADD CONSTRAINT FK_ABF1009AEA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id)');
        $this->addSql('CREATE INDEX IDX_ABF1009AEA9FDD75 ON figures (media_id)');
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10C5C011B5');
        $this->addSql('DROP INDEX IDX_6A2CA10C5C011B5 ON media');
        $this->addSql('ALTER TABLE media DROP figure_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE figures DROP FOREIGN KEY FK_ABF1009AEA9FDD75');
        $this->addSql('DROP INDEX IDX_ABF1009AEA9FDD75 ON figures');
        $this->addSql('ALTER TABLE figures DROP media_id');
        $this->addSql('ALTER TABLE media ADD figure_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10C5C011B5 FOREIGN KEY (figure_id) REFERENCES figures (id)');
        $this->addSql('CREATE INDEX IDX_6A2CA10C5C011B5 ON media (figure_id)');
    }
}
