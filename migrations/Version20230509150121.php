<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230509150121 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE offre');
        $this->addSql('ALTER TABLE sous_categorie ADD categorie_id INT NOT NULL');
        $this->addSql('ALTER TABLE sous_categorie ADD CONSTRAINT FK_52743D7BBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_52743D7BBCF5E72D ON sous_categorie (categorie_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE offre (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, debut DATE NOT NULL, fin DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE sous_categorie DROP FOREIGN KEY FK_52743D7BBCF5E72D');
        $this->addSql('DROP INDEX IDX_52743D7BBCF5E72D ON sous_categorie');
        $this->addSql('ALTER TABLE sous_categorie DROP categorie_id');
    }
}
