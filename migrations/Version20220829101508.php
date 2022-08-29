<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220829101508 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comments ADD figure_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A6D69186E FOREIGN KEY (figure_id_id) REFERENCES figures (id)');
        $this->addSql('CREATE INDEX IDX_5F9E962A6D69186E ON comments (figure_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A6D69186E');
        $this->addSql('DROP INDEX IDX_5F9E962A6D69186E ON comments');
        $this->addSql('ALTER TABLE comments DROP figure_id_id');
    }
}
