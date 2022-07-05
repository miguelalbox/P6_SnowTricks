<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220705153727 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE figures (id INT AUTO_INCREMENT NOT NULL, groups_id INT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL, INDEX IDX_ABF1009AF373DCF (groups_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE figures ADD CONSTRAINT FK_ABF1009AF373DCF FOREIGN KEY (groups_id) REFERENCES groups (id)');
        $this->addSql('ALTER TABLE media ADD figures_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10C5C7F3A37 FOREIGN KEY (figures_id) REFERENCES figures (id)');
        $this->addSql('CREATE INDEX IDX_6A2CA10C5C7F3A37 ON media (figures_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10C5C7F3A37');
        $this->addSql('DROP TABLE figures');
        $this->addSql('DROP INDEX IDX_6A2CA10C5C7F3A37 ON media');
        $this->addSql('ALTER TABLE media DROP figures_id');
    }
}
