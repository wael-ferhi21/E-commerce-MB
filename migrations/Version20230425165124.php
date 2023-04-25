<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230425165124 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorie DROP catid');
        $this->addSql('ALTER TABLE client DROP sexe, DROP num_tel');
        $this->addSql('ALTER TABLE commande DROP comdid');
        $this->addSql('ALTER TABLE facture DROP factid');
        $this->addSql('ALTER TABLE livraison DROP liv_id');
        $this->addSql('ALTER TABLE panier DROP p_id');
        $this->addSql('ALTER TABLE produit DROP prod_design, CHANGE prod_id categorie_id INT NOT NULL');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_29A5EC27BCF5E72D ON produit (categorie_id)');
        $this->addSql('ALTER TABLE sous_categorie DROP id_sc');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorie ADD catid INT NOT NULL');
        $this->addSql('ALTER TABLE client ADD sexe VARCHAR(255) NOT NULL, ADD num_tel VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE commande ADD comdid INT NOT NULL');
        $this->addSql('ALTER TABLE facture ADD factid INT NOT NULL');
        $this->addSql('ALTER TABLE livraison ADD liv_id INT NOT NULL');
        $this->addSql('ALTER TABLE panier ADD p_id INT NOT NULL');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27BCF5E72D');
        $this->addSql('DROP INDEX IDX_29A5EC27BCF5E72D ON produit');
        $this->addSql('ALTER TABLE produit ADD prod_design VARCHAR(255) NOT NULL, CHANGE categorie_id prod_id INT NOT NULL');
        $this->addSql('ALTER TABLE sous_categorie ADD id_sc INT NOT NULL');
    }
}
