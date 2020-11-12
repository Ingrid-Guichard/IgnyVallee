<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200512153645 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE parcelles DROP FOREIGN KEY FK_4F15F60E86696F99');
        $this->addSql('ALTER TABLE recoltes_legume DROP FOREIGN KEY FK_EBF6F48C86696F99');
        $this->addSql('ALTER TABLE sachets_graines DROP FOREIGN KEY FK_AE06117286696F99');
        $this->addSql('ALTER TABLE ruchers DROP FOREIGN KEY FK_76D6246CA3276C3');
        $this->addSql('ALTER TABLE arbres DROP FOREIGN KEY FK_E6A4F221CA0C542A');
        $this->addSql('ALTER TABLE recoltes_fruit DROP FOREIGN KEY FK_ED683682CA0C542A');
        $this->addSql('DROP TABLE potager_activite');
        $this->addSql('DROP TABLE rucher_activite');
        $this->addSql('DROP TABLE verger_activite');
        $this->addSql('ALTER TABLE adherents CHANGE prix_adhesion prix_adhesion DOUBLE PRECISION DEFAULT NULL, CHANGE type_paiement type_paiement VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE ruches CHANGE emplacement_ruche emplacement_ruche VARCHAR(255) DEFAULT NULL, CHANGE date_installation_ruche date_installation_ruche DATE DEFAULT NULL, CHANGE origine_colonie origine_colonie VARCHAR(255) DEFAULT NULL, CHANGE date_installation_colonie date_installation_colonie DATE DEFAULT NULL, CHANGE espece_colonie espece_colonie VARCHAR(255) DEFAULT NULL, CHANGE naissance_reine naissance_reine DATE DEFAULT NULL, CHANGE nourrisseurs nourrisseurs VARCHAR(255) DEFAULT NULL, CHANGE muselieres muselieres TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE fiches_de_visite CHANGE poids_ruche poids_ruche DOUBLE PRECISION DEFAULT NULL, CHANGE origine_colonie origine_colonie VARCHAR(255) DEFAULT NULL, CHANGE espece_colonie espece_colonie VARCHAR(255) DEFAULT NULL, CHANGE date_installation_colonie date_installation_colonie DATE DEFAULT NULL, CHANGE naissance_reine naissance_reine DATE DEFAULT NULL, CHANGE volume_sirop_leger volume_sirop_leger DOUBLE PRECISION DEFAULT NULL, CHANGE nb_cadres_couvain nb_cadres_couvain INT DEFAULT NULL, CHANGE nb_cadres_miel nb_cadres_miel INT DEFAULT NULL, CHANGE nb_cadres_pollen nb_cadres_pollen INT DEFAULT NULL, CHANGE cadre1 cadre1 VARCHAR(255) DEFAULT NULL, CHANGE cadre2 cadre2 VARCHAR(255) DEFAULT NULL, CHANGE cadre3 cadre3 VARCHAR(255) DEFAULT NULL, CHANGE cadre4 cadre4 VARCHAR(255) DEFAULT NULL, CHANGE cadre5 cadre5 VARCHAR(255) DEFAULT NULL, CHANGE cadre6 cadre6 VARCHAR(255) DEFAULT NULL, CHANGE cadre7 cadre7 VARCHAR(255) DEFAULT NULL, CHANGE cadre8 cadre8 VARCHAR(255) DEFAULT NULL, CHANGE cadre9 cadre9 VARCHAR(255) DEFAULT NULL, CHANGE cadre10 cadre10 VARCHAR(255) DEFAULT NULL, CHANGE calcul_varroa calcul_varroa DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_4F15F60E86696F99 ON parcelles');
        $this->addSql('ALTER TABLE parcelles ADD activite_id INT NOT NULL, DROP potager_activite_id, CHANGE etat_terre_parcelle etat_terre_parcelle VARCHAR(255) DEFAULT NULL, CHANGE plantation_parcelle plantation_parcelle VARCHAR(255) DEFAULT NULL, CHANGE historique1_plantation_parcelle historique1_plantation_parcelle VARCHAR(255) DEFAULT NULL, CHANGE historique2_plantation_parcelle historique2_plantation_parcelle VARCHAR(255) DEFAULT NULL, CHANGE historique3_plantation_parcelle historique3_plantation_parcelle VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE parcelles ADD CONSTRAINT FK_4F15F60E9B0F88B1 FOREIGN KEY (activite_id) REFERENCES activites (id)');
        $this->addSql('CREATE INDEX IDX_4F15F60E9B0F88B1 ON parcelles (activite_id)');
        $this->addSql('DROP INDEX IDX_76D6246CA3276C3 ON ruchers');
        $this->addSql('ALTER TABLE ruchers ADD activite_id INT NOT NULL, DROP rucher_activite_id, CHANGE description_rucher description_rucher VARCHAR(255) DEFAULT NULL, CHANGE partenaire_rucher partenaire_rucher VARCHAR(255) DEFAULT NULL, CHANGE date_creation_rucher date_creation_rucher DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE ruchers ADD CONSTRAINT FK_76D62469B0F88B1 FOREIGN KEY (activite_id) REFERENCES activites (id)');
        $this->addSql('CREATE INDEX IDX_76D62469B0F88B1 ON ruchers (activite_id)');
        $this->addSql('ALTER TABLE activites ADD description LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE recoltes_miel CHANGE prix_pot_miel prix_pot_miel DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE participants CHANGE adherent_id adherent_id INT DEFAULT NULL, CHANGE type_paiement type_paiement VARCHAR(255) DEFAULT NULL, CHANGE is_payed is_payed TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE igny_valle_user CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE events CHANGE partenaire_id partenaire_id INT DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_E6A4F221CA0C542A ON arbres');
        $this->addSql('ALTER TABLE arbres ADD activite_id INT NOT NULL, DROP verger_activite_id, CHANGE adherent_id adherent_id INT DEFAULT NULL, CHANGE etat_arbre etat_arbre VARCHAR(255) DEFAULT NULL, CHANGE age_arbre age_arbre INT DEFAULT NULL, CHANGE fructification_arbre fructification_arbre TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE arbres ADD CONSTRAINT FK_E6A4F2219B0F88B1 FOREIGN KEY (activite_id) REFERENCES activites (id)');
        $this->addSql('CREATE INDEX IDX_E6A4F2219B0F88B1 ON arbres (activite_id)');
        $this->addSql('ALTER TABLE emprunts CHANGE date_fin date_fin DATE DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_ED683682CA0C542A ON recoltes_fruit');
        $this->addSql('ALTER TABLE recoltes_fruit ADD activite_id INT NOT NULL, DROP verger_activite_id, CHANGE date_recolte_fruit date_recolte_fruit DATE DEFAULT NULL, CHANGE prix_kg_fruit prix_kg_fruit DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE recoltes_fruit ADD CONSTRAINT FK_ED6836829B0F88B1 FOREIGN KEY (activite_id) REFERENCES activites (id)');
        $this->addSql('CREATE INDEX IDX_ED6836829B0F88B1 ON recoltes_fruit (activite_id)');
        $this->addSql('DROP INDEX IDX_AE06117286696F99 ON sachets_graines');
        $this->addSql('ALTER TABLE sachets_graines ADD activite_id INT NOT NULL, DROP potager_activite_id, CHANGE saison_plantation_graines saison_plantation_graines VARCHAR(255) DEFAULT NULL, CHANGE qualite_graines qualite_graines VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE sachets_graines ADD CONSTRAINT FK_AE0611729B0F88B1 FOREIGN KEY (activite_id) REFERENCES activites (id)');
        $this->addSql('CREATE INDEX IDX_AE0611729B0F88B1 ON sachets_graines (activite_id)');
        $this->addSql('ALTER TABLE partenaires CHANGE date_partenariat date_partenariat DATE DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_EBF6F48C86696F99 ON recoltes_legume');
        $this->addSql('ALTER TABLE recoltes_legume ADD activite_id INT NOT NULL, DROP potager_activite_id, CHANGE nb_kg_recolte_legume nb_kg_recolte_legume DOUBLE PRECISION DEFAULT NULL, CHANGE prix_legume prix_legume DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE recoltes_legume ADD CONSTRAINT FK_EBF6F48C9B0F88B1 FOREIGN KEY (activite_id) REFERENCES activites (id)');
        $this->addSql('CREATE INDEX IDX_EBF6F48C9B0F88B1 ON recoltes_legume (activite_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE potager_activite (id VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, activite_id INT NOT NULL, description_potager_activite LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_FA84AF349B0F88B1 (activite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE rucher_activite (id VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, activite_id INT NOT NULL, description_rucher_activite LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_292172909B0F88B1 (activite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE verger_activite (id VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, activite_id INT NOT NULL, description_verger_activite LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_DEEACBB19B0F88B1 (activite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE potager_activite ADD CONSTRAINT FK_FA84AF349B0F88B1 FOREIGN KEY (activite_id) REFERENCES activites (id)');
        $this->addSql('ALTER TABLE rucher_activite ADD CONSTRAINT FK_292172909B0F88B1 FOREIGN KEY (activite_id) REFERENCES activites (id)');
        $this->addSql('ALTER TABLE verger_activite ADD CONSTRAINT FK_DEEACBB19B0F88B1 FOREIGN KEY (activite_id) REFERENCES activites (id)');
        $this->addSql('ALTER TABLE activites DROP description');
        $this->addSql('ALTER TABLE adherents CHANGE prix_adhesion prix_adhesion DOUBLE PRECISION DEFAULT \'NULL\', CHANGE type_paiement type_paiement VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE arbres DROP FOREIGN KEY FK_E6A4F2219B0F88B1');
        $this->addSql('DROP INDEX IDX_E6A4F2219B0F88B1 ON arbres');
        $this->addSql('ALTER TABLE arbres ADD verger_activite_id VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP activite_id, CHANGE adherent_id adherent_id INT DEFAULT NULL, CHANGE etat_arbre etat_arbre VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE age_arbre age_arbre INT DEFAULT NULL, CHANGE fructification_arbre fructification_arbre TINYINT(1) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE arbres ADD CONSTRAINT FK_E6A4F221CA0C542A FOREIGN KEY (verger_activite_id) REFERENCES verger_activite (id)');
        $this->addSql('CREATE INDEX IDX_E6A4F221CA0C542A ON arbres (verger_activite_id)');
        $this->addSql('ALTER TABLE emprunts CHANGE date_fin date_fin DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE events CHANGE partenaire_id partenaire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fiches_de_visite CHANGE poids_ruche poids_ruche DOUBLE PRECISION DEFAULT \'NULL\', CHANGE origine_colonie origine_colonie VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE espece_colonie espece_colonie VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE date_installation_colonie date_installation_colonie DATE DEFAULT \'NULL\', CHANGE naissance_reine naissance_reine DATE DEFAULT \'NULL\', CHANGE volume_sirop_leger volume_sirop_leger DOUBLE PRECISION DEFAULT \'NULL\', CHANGE nb_cadres_couvain nb_cadres_couvain INT DEFAULT NULL, CHANGE nb_cadres_miel nb_cadres_miel INT DEFAULT NULL, CHANGE nb_cadres_pollen nb_cadres_pollen INT DEFAULT NULL, CHANGE cadre1 cadre1 VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE cadre2 cadre2 VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE cadre3 cadre3 VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE cadre4 cadre4 VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE cadre5 cadre5 VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE cadre6 cadre6 VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE cadre7 cadre7 VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE cadre8 cadre8 VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE cadre9 cadre9 VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE cadre10 cadre10 VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE calcul_varroa calcul_varroa DOUBLE PRECISION DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE igny_valle_user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
        $this->addSql('ALTER TABLE parcelles DROP FOREIGN KEY FK_4F15F60E9B0F88B1');
        $this->addSql('DROP INDEX IDX_4F15F60E9B0F88B1 ON parcelles');
        $this->addSql('ALTER TABLE parcelles ADD potager_activite_id VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP activite_id, CHANGE etat_terre_parcelle etat_terre_parcelle VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE plantation_parcelle plantation_parcelle VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE historique1_plantation_parcelle historique1_plantation_parcelle VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE historique2_plantation_parcelle historique2_plantation_parcelle VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE historique3_plantation_parcelle historique3_plantation_parcelle VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE parcelles ADD CONSTRAINT FK_4F15F60E86696F99 FOREIGN KEY (potager_activite_id) REFERENCES potager_activite (id)');
        $this->addSql('CREATE INDEX IDX_4F15F60E86696F99 ON parcelles (potager_activite_id)');
        $this->addSql('ALTER TABLE partenaires CHANGE date_partenariat date_partenariat DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE participants CHANGE adherent_id adherent_id INT DEFAULT NULL, CHANGE type_paiement type_paiement VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE is_payed is_payed TINYINT(1) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE recoltes_fruit DROP FOREIGN KEY FK_ED6836829B0F88B1');
        $this->addSql('DROP INDEX IDX_ED6836829B0F88B1 ON recoltes_fruit');
        $this->addSql('ALTER TABLE recoltes_fruit ADD verger_activite_id VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP activite_id, CHANGE date_recolte_fruit date_recolte_fruit DATE DEFAULT \'NULL\', CHANGE prix_kg_fruit prix_kg_fruit DOUBLE PRECISION DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE recoltes_fruit ADD CONSTRAINT FK_ED683682CA0C542A FOREIGN KEY (verger_activite_id) REFERENCES verger_activite (id)');
        $this->addSql('CREATE INDEX IDX_ED683682CA0C542A ON recoltes_fruit (verger_activite_id)');
        $this->addSql('ALTER TABLE recoltes_legume DROP FOREIGN KEY FK_EBF6F48C9B0F88B1');
        $this->addSql('DROP INDEX IDX_EBF6F48C9B0F88B1 ON recoltes_legume');
        $this->addSql('ALTER TABLE recoltes_legume ADD potager_activite_id VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP activite_id, CHANGE nb_kg_recolte_legume nb_kg_recolte_legume DOUBLE PRECISION DEFAULT \'NULL\', CHANGE prix_legume prix_legume DOUBLE PRECISION DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE recoltes_legume ADD CONSTRAINT FK_EBF6F48C86696F99 FOREIGN KEY (potager_activite_id) REFERENCES potager_activite (id)');
        $this->addSql('CREATE INDEX IDX_EBF6F48C86696F99 ON recoltes_legume (potager_activite_id)');
        $this->addSql('ALTER TABLE recoltes_miel CHANGE prix_pot_miel prix_pot_miel DOUBLE PRECISION DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE ruchers DROP FOREIGN KEY FK_76D62469B0F88B1');
        $this->addSql('DROP INDEX IDX_76D62469B0F88B1 ON ruchers');
        $this->addSql('ALTER TABLE ruchers ADD rucher_activite_id VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP activite_id, CHANGE description_rucher description_rucher VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE partenaire_rucher partenaire_rucher VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE date_creation_rucher date_creation_rucher DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE ruchers ADD CONSTRAINT FK_76D6246CA3276C3 FOREIGN KEY (rucher_activite_id) REFERENCES rucher_activite (id)');
        $this->addSql('CREATE INDEX IDX_76D6246CA3276C3 ON ruchers (rucher_activite_id)');
        $this->addSql('ALTER TABLE ruches CHANGE emplacement_ruche emplacement_ruche VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE date_installation_ruche date_installation_ruche DATE DEFAULT \'NULL\', CHANGE origine_colonie origine_colonie VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE date_installation_colonie date_installation_colonie DATE DEFAULT \'NULL\', CHANGE espece_colonie espece_colonie VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE naissance_reine naissance_reine DATE DEFAULT \'NULL\', CHANGE nourrisseurs nourrisseurs VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE muselieres muselieres TINYINT(1) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE sachets_graines DROP FOREIGN KEY FK_AE0611729B0F88B1');
        $this->addSql('DROP INDEX IDX_AE0611729B0F88B1 ON sachets_graines');
        $this->addSql('ALTER TABLE sachets_graines ADD potager_activite_id VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP activite_id, CHANGE saison_plantation_graines saison_plantation_graines VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE qualite_graines qualite_graines VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE sachets_graines ADD CONSTRAINT FK_AE06117286696F99 FOREIGN KEY (potager_activite_id) REFERENCES potager_activite (id)');
        $this->addSql('CREATE INDEX IDX_AE06117286696F99 ON sachets_graines (potager_activite_id)');
    }
}
