<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220707095852 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE boisson_menu (id INT AUTO_INCREMENT NOT NULL, taille_id INT DEFAULT NULL, menu_id INT DEFAULT NULL, quantite INT DEFAULT NULL, INDEX IDX_1391FF6CFF25611A (taille_id), INDEX IDX_1391FF6CCCD7E912 (menu_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE boisson_menu ADD CONSTRAINT FK_1391FF6CFF25611A FOREIGN KEY (taille_id) REFERENCES taille_boisson (id)');
        $this->addSql('ALTER TABLE boisson_menu ADD CONSTRAINT FK_1391FF6CCCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
        $this->addSql('ALTER TABLE frite_menu ADD menu_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE frite_menu ADD CONSTRAINT FK_889E9BC6CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
        $this->addSql('CREATE INDEX IDX_889E9BC6CCD7E912 ON frite_menu (menu_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE boisson_menu');
        $this->addSql('ALTER TABLE frite_menu DROP FOREIGN KEY FK_889E9BC6CCD7E912');
        $this->addSql('DROP INDEX IDX_889E9BC6CCD7E912 ON frite_menu');
        $this->addSql('ALTER TABLE frite_menu DROP menu_id');
    }
}
