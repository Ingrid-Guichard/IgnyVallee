<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200527133557 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE ateliers_taches (ateliers_id INT NOT NULL, taches_id INT NOT NULL, INDEX IDX_5E2106BAB1409BC9 (ateliers_id), INDEX IDX_5E2106BAB8A61670 (taches_id), PRIMARY KEY(ateliers_id, taches_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ateliers_taches ADD CONSTRAINT FK_5E2106BAB1409BC9 FOREIGN KEY (ateliers_id) REFERENCES ateliers (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ateliers_taches ADD CONSTRAINT FK_5E2106BAB8A61670 FOREIGN KEY (taches_id) REFERENCES taches (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE taches_ateliers');
        $this->addSql('ALTER TABLE adherents CHANGE prix_adhesion prix_adhesion DOUBLE PRECISION DEFAULT NULL, CHANGE type_paiement type_paiement VARCHAR(255) DEFAULT NULL, CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE ruches CHANGE emplacement_ruche emplacement_ruche VARCHAR(255) DEFAULT NULL, CHANGE date_installation_ruche date_installation_ruche DATE DEFAULT NULL, CHANGE origine_colonie origine_colonie VARCHAR(255) DEFAULT NULL, CHANGE date_installation_colonie date_installation_colonie DATE DEFAULT NULL, CHANGE espece_colonie espece_colonie VARCHAR(255) DEFAULT NULL, CHANGE naissance_reine naissance_reine DATE DEFAULT NULL, CHANGE nourrisseurs nourrisseurs VARCHAR(255) DEFAULT NULL, CHANGE muselieres muselieres TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE fiches_de_visite CHANGE poids_ruche poids_ruche DOUBLE PRECISION DEFAULT NULL, CHANGE origine_colonie origine_colonie VARCHAR(255) DEFAULT NULL, CHANGE espece_colonie espece_colonie VARCHAR(255) DEFAULT NULL, CHANGE date_installation_colonie date_installation_colonie DATE DEFAULT NULL, CHANGE naissance_reine naissance_reine DATE DEFAULT NULL, CHANGE volume_sirop_leger volume_sirop_leger DOUBLE PRECISION DEFAULT NULL, CHANGE nb_cadres_couvain nb_cadres_couvain INT DEFAULT NULL, CHANGE nb_cadres_miel nb_cadres_miel INT DEFAULT NULL, CHANGE nb_cadres_pollen nb_cadres_pollen INT DEFAULT NULL, CHANGE cadre1 cadre1 VARCHAR(255) DEFAULT NULL, CHANGE cadre2 cadre2 VARCHAR(255) DEFAULT NULL, CHANGE cadre3 cadre3 VARCHAR(255) DEFAULT NULL, CHANGE cadre4 cadre4 VARCHAR(255) DEFAULT NULL, CHANGE cadre5 cadre5 VARCHAR(255) DEFAULT NULL, CHANGE cadre6 cadre6 VARCHAR(255) DEFAULT NULL, CHANGE cadre7 cadre7 VARCHAR(255) DEFAULT NULL, CHANGE cadre8 cadre8 VARCHAR(255) DEFAULT NULL, CHANGE cadre9 cadre9 VARCHAR(255) DEFAULT NULL, CHANGE cadre10 cadre10 VARCHAR(255) DEFAULT NULL, CHANGE calcul_varroa calcul_varroa DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE parcelles CHANGE etat_terre_parcelle etat_terre_parcelle VARCHAR(255) DEFAULT NULL, CHANGE plantation_parcelle plantation_parcelle VARCHAR(255) DEFAULT NULL, CHANGE historique1_plantation_parcelle historique1_plantation_parcelle VARCHAR(255) DEFAULT NULL, CHANGE historique2_plantation_parcelle historique2_plantation_parcelle VARCHAR(255) DEFAULT NULL, CHANGE historique3_plantation_parcelle historique3_plantation_parcelle VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE ruchers CHANGE description_rucher description_rucher VARCHAR(255) DEFAULT NULL, CHANGE partenaire_rucher partenaire_rucher VARCHAR(255) DEFAULT NULL, CHANGE date_creation_rucher date_creation_rucher DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE recoltes_miel CHANGE prix_pot_miel prix_pot_miel DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE participants CHANGE adherent_id adherent_id INT DEFAULT NULL, CHANGE type_paiement type_paiement VARCHAR(255) DEFAULT NULL, CHANGE is_payed is_payed TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE igny_valle_user CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE events CHANGE partenaire_id partenaire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE arbres CHANGE adherent_id adherent_id INT DEFAULT NULL, CHANGE etat_arbre etat_arbre VARCHAR(255) DEFAULT NULL, CHANGE age_arbre age_arbre INT DEFAULT NULL, CHANGE fructification_arbre fructification_arbre TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE emprunts CHANGE date_fin date_fin DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE recoltes_fruit CHANGE date_recolte_fruit date_recolte_fruit DATE DEFAULT NULL, CHANGE prix_kg_fruit prix_kg_fruit DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE sachets_graines CHANGE saison_plantation_graines saison_plantation_graines VARCHAR(255) DEFAULT NULL, CHANGE qualite_graines qualite_graines VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE partenaires CHANGE date_partenariat date_partenariat DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE recoltes_legume CHANGE nb_kg_recolte_legume nb_kg_recolte_legume DOUBLE PRECISION DEFAULT NULL, CHANGE prix_legume prix_legume DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE taches_ateliers (taches_id INT NOT NULL, ateliers_id INT NOT NULL, INDEX IDX_9AFA2E5FB8A61670 (taches_id), INDEX IDX_9AFA2E5FB1409BC9 (ateliers_id), PRIMARY KEY(taches_id, ateliers_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE taches_ateliers ADD CONSTRAINT FK_9AFA2E5FB1409BC9 FOREIGN KEY (ateliers_id) REFERENCES ateliers (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE taches_ateliers ADD CONSTRAINT FK_9AFA2E5FB8A61670 FOREIGN KEY (taches_id) REFERENCES taches (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE ateliers_taches');
        $this->addSql('ALTER TABLE adherents CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`, CHANGE prix_adhesion prix_adhesion DOUBLE PRECISION DEFAULT \'NULL\', CHANGE type_paiement type_paiement VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE arbres CHANGE adherent_id adherent_id INT DEFAULT NULL, CHANGE etat_arbre etat_arbre VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE age_arbre age_arbre INT DEFAULT NULL, CHANGE fructification_arbre fructification_arbre TINYINT(1) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE emprunts CHANGE date_fin date_fin DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE events CHANGE partenaire_id partenaire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fiches_de_visite CHANGE poids_ruche poids_ruche DOUBLE PRECISION DEFAULT \'NULL\', CHANGE origine_colonie origine_colonie VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE espece_colonie espece_colonie VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE date_installation_colonie date_installation_colonie DATE DEFAULT \'NULL\', CHANGE naissance_reine naissance_reine DATE DEFAULT \'NULL\', CHANGE volume_sirop_leger volume_sirop_leger DOUBLE PRECISION DEFAULT \'NULL\', CHANGE nb_cadres_couvain nb_cadres_couvain INT DEFAULT NULL, CHANGE nb_cadres_miel nb_cadres_miel INT DEFAULT NULL, CHANGE nb_cadres_pollen nb_cadres_pollen INT DEFAULT NULL, CHANGE cadre1 cadre1 VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE cadre2 cadre2 VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE cadre3 cadre3 VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE cadre4 cadre4 VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE cadre5 cadre5 VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE cadre6 cadre6 VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE cadre7 cadre7 VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE cadre8 cadre8 VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE cadre9 cadre9 VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE cadre10 cadre10 VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE calcul_varroa calcul_varroa DOUBLE PRECISION DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE igny_valle_user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
        $this->addSql('ALTER TABLE parcelles CHANGE etat_terre_parcelle etat_terre_parcelle VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE plantation_parcelle plantation_parcelle VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE historique1_plantation_parcelle historique1_plantation_parcelle VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE historique2_plantation_parcelle historique2_plantation_parcelle VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE historique3_plantation_parcelle historique3_plantation_parcelle VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE partenaires CHANGE date_partenariat date_partenariat DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE participants CHANGE adherent_id adherent_id INT DEFAULT NULL, CHANGE type_paiement type_paiement VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE is_payed is_payed TINYINT(1) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE recoltes_fruit CHANGE date_recolte_fruit date_recolte_fruit DATE DEFAULT \'NULL\', CHANGE prix_kg_fruit prix_kg_fruit DOUBLE PRECISION DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE recoltes_legume CHANGE nb_kg_recolte_legume nb_kg_recolte_legume DOUBLE PRECISION DEFAULT \'NULL\', CHANGE prix_legume prix_legume DOUBLE PRECISION DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE recoltes_miel CHANGE prix_pot_miel prix_pot_miel DOUBLE PRECISION DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE ruchers CHANGE description_rucher description_rucher VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE partenaire_rucher partenaire_rucher VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE date_creation_rucher date_creation_rucher DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE ruches CHANGE emplacement_ruche emplacement_ruche VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE date_installation_ruche date_installation_ruche DATE DEFAULT \'NULL\', CHANGE origine_colonie origine_colonie VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE date_installation_colonie date_installation_colonie DATE DEFAULT \'NULL\', CHANGE espece_colonie espece_colonie VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE naissance_reine naissance_reine DATE DEFAULT \'NULL\', CHANGE nourrisseurs nourrisseurs VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE muselieres muselieres TINYINT(1) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE sachets_graines CHANGE saison_plantation_graines saison_plantation_graines VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE qualite_graines qualite_graines VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
    }
}
