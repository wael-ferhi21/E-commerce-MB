<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230428101708 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adresse (id INT AUTO_INCREMENT NOT NULL, adresseclient_id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, nomadr VARCHAR(255) NOT NULL, société VARCHAR(255) NOT NULL, codepostal VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, cité VARCHAR(255) NOT NULL, pays VARCHAR(255) NOT NULL, numtel VARCHAR(255) NOT NULL, INDEX IDX_C35F08165735BC2B (adresseclient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE adresse ADD CONSTRAINT FK_C35F08165735BC2B FOREIGN KEY (adresseclient_id) REFERENCES client (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adresse DROP FOREIGN KEY FK_C35F08165735BC2B');
        $this->addSql('DROP TABLE adresse');
    }
}
