<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220630083617 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE menu_frite (menu_id INT NOT NULL, frite_id INT NOT NULL, INDEX IDX_B147E70ACCD7E912 (menu_id), INDEX IDX_B147E70ABE00B4D9 (frite_id), PRIMARY KEY(menu_id, frite_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE taille_boisson (id INT AUTO_INCREMENT NOT NULL, size VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE taille_boisson_boisson (taille_boisson_id INT NOT NULL, boisson_id INT NOT NULL, INDEX IDX_26598B598421F13F (taille_boisson_id), INDEX IDX_26598B59734B8089 (boisson_id), PRIMARY KEY(taille_boisson_id, boisson_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE menu_frite ADD CONSTRAINT FK_B147E70ACCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_frite ADD CONSTRAINT FK_B147E70ABE00B4D9 FOREIGN KEY (frite_id) REFERENCES frite (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE taille_boisson_boisson ADD CONSTRAINT FK_26598B598421F13F FOREIGN KEY (taille_boisson_id) REFERENCES taille_boisson (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE taille_boisson_boisson ADD CONSTRAINT FK_26598B59734B8089 FOREIGN KEY (boisson_id) REFERENCES boisson (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE boisson DROP portion_boisson');
        $this->addSql('ALTER TABLE menu ADD taille_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A93FF25611A FOREIGN KEY (taille_id) REFERENCES taille_boisson (id)');
        $this->addSql('CREATE INDEX IDX_7D053A93FF25611A ON menu (taille_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A93FF25611A');
        $this->addSql('ALTER TABLE taille_boisson_boisson DROP FOREIGN KEY FK_26598B598421F13F');
        $this->addSql('DROP TABLE menu_frite');
        $this->addSql('DROP TABLE taille_boisson');
        $this->addSql('DROP TABLE taille_boisson_boisson');
        $this->addSql('ALTER TABLE boisson ADD portion_boisson VARCHAR(255) DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_7D053A93FF25611A ON menu');
        $this->addSql('ALTER TABLE menu DROP taille_id');
    }
}
