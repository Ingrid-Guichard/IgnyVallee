<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200511131834 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE activites (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE adherents (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, mdp VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, debut_adhesion DATE NOT NULL, fin_adhesion DATE NOT NULL, is_act_potager TINYINT(1) NOT NULL, is_act_verger TINYINT(1) NOT NULL, is_act_rucher TINYINT(1) NOT NULL, is_act_animation TINYINT(1) NOT NULL, is_act_promotion TINYINT(1) NOT NULL, is_int_potager TINYINT(1) NOT NULL, is_int_verger TINYINT(1) NOT NULL, is_int_rucher TINYINT(1) NOT NULL, is_int_animation TINYINT(1) NOT NULL, is_admin TINYINT(1) NOT NULL, is_referent TINYINT(1) NOT NULL, prix_adhesion DOUBLE PRECISION NOT NULL, is_payed TINYINT(1) NOT NULL, type_paiement VARCHAR(255) DEFAULT NULL, is_archive TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_562C7DA3E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE adherents_ateliers (adherents_id INT NOT NULL, ateliers_id INT NOT NULL, INDEX IDX_AFFEC26B15364D07 (adherents_id), INDEX IDX_AFFEC26BB1409BC9 (ateliers_id), PRIMARY KEY(adherents_id, ateliers_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE adherents_activites (adherents_id INT NOT NULL, activites_id INT NOT NULL, INDEX IDX_96A8C16C15364D07 (adherents_id), INDEX IDX_96A8C16C5B8C31B7 (activites_id), PRIMARY KEY(adherents_id, activites_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE admins (id INT AUTO_INCREMENT NOT NULL, adherent_id INT NOT NULL, heures_gestion_admin INT NOT NULL, UNIQUE INDEX UNIQ_A2E0150F25F06C53 (adherent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE arbres (id INT AUTO_INCREMENT NOT NULL, verger_activite_id VARCHAR(255) NOT NULL, adherent_id INT DEFAULT NULL, colonne_arbre INT NOT NULL, ligne_arbre INT NOT NULL, nom_fruit_arbre VARCHAR(255) NOT NULL, etat_arbre VARCHAR(255) DEFAULT NULL, age_arbre INT DEFAULT NULL, fructification_arbre TINYINT(1) DEFAULT NULL, INDEX IDX_E6A4F221CA0C542A (verger_activite_id), INDEX IDX_E6A4F22125F06C53 (adherent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE articles (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, contenu LONGTEXT NOT NULL, date DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ateliers (id INT AUTO_INCREMENT NOT NULL, activite_id INT NOT NULL, nom VARCHAR(255) NOT NULL, date_debut DATETIME NOT NULL, date_fin DATETIME NOT NULL, description LONGTEXT DEFAULT NULL, heures_gestion_atelier INT NOT NULL, INDEX IDX_B98805619B0F88B1 (activite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ateliers_referents (ateliers_id INT NOT NULL, referents_id INT NOT NULL, INDEX IDX_53E967D4B1409BC9 (ateliers_id), INDEX IDX_53E967D4B1F79D78 (referents_id), PRIMARY KEY(ateliers_id, referents_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cotisations (id INT AUTO_INCREMENT NOT NULL, adherent_id INT NOT NULL, debut_cotisation DATE NOT NULL, fin_cotisation DATE NOT NULL, prix DOUBLE PRECISION NOT NULL, type_paiement VARCHAR(255) NOT NULL, INDEX IDX_C51B351C25F06C53 (adherent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE emprunts (id INT AUTO_INCREMENT NOT NULL, outil_id INT NOT NULL, adherent_id INT NOT NULL, date_debut DATE NOT NULL, date_fin DATE DEFAULT NULL, nb_exemplaires INT NOT NULL, INDEX IDX_38FC80D3ED89C80 (outil_id), INDEX IDX_38FC80D25F06C53 (adherent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE events (id INT AUTO_INCREMENT NOT NULL, partenaire_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, date_debut DATETIME NOT NULL, date_fin DATETIME NOT NULL, prix DOUBLE PRECISION NOT NULL, description LONGTEXT DEFAULT NULL, heures_gestion_event INT NOT NULL, INDEX IDX_5387574A98DE13AC (partenaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE events_admins (events_id INT NOT NULL, admins_id INT NOT NULL, INDEX IDX_705D2C3A9D6A1065 (events_id), INDEX IDX_705D2C3AFAA286C3 (admins_id), PRIMARY KEY(events_id, admins_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fiches_de_visite (id INT AUTO_INCREMENT NOT NULL, rucher_id INT NOT NULL, date_visite DATE NOT NULL, objectifs LONGTEXT DEFAULT NULL, id_adherent INT NOT NULL, saison_visite VARCHAR(255) NOT NULL, observations LONGTEXT DEFAULT NULL, poids_ruche DOUBLE PRECISION DEFAULT NULL, origine_colonie VARCHAR(255) DEFAULT NULL, espece_colonie VARCHAR(255) DEFAULT NULL, date_installation_colonie DATE DEFAULT NULL, naissance_reine DATE DEFAULT NULL, qualite_population VARCHAR(255) NOT NULL, reine_appercue TINYINT(1) NOT NULL, reine_marquee TINYINT(1) NOT NULL, taux_agressivite_abeilles INT NOT NULL, abeilles_nourries VARCHAR(255) NOT NULL, volume_sirop_leger DOUBLE PRECISION DEFAULT NULL, nb_cadres_couvain INT DEFAULT NULL, nb_cadres_miel INT DEFAULT NULL, nb_cadres_pollen INT DEFAULT NULL, cadre1 VARCHAR(255) DEFAULT NULL, cadre2 VARCHAR(255) DEFAULT NULL, cadre3 VARCHAR(255) DEFAULT NULL, cadre4 VARCHAR(255) DEFAULT NULL, cadre5 VARCHAR(255) DEFAULT NULL, cadre6 VARCHAR(255) DEFAULT NULL, cadre7 VARCHAR(255) DEFAULT NULL, cadre8 VARCHAR(255) DEFAULT NULL, cadre9 VARCHAR(255) DEFAULT NULL, cadre10 VARCHAR(255) DEFAULT NULL, calcul_varroa DOUBLE PRECISION DEFAULT NULL, INDEX IDX_C40266658BF1374E (rucher_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images (id INT AUTO_INCREMENT NOT NULL, article_id INT NOT NULL, url VARCHAR(255) NOT NULL, alt VARCHAR(255) NOT NULL, INDEX IDX_E01FBE6A7294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE outils (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, emplacement VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parcelles (id INT AUTO_INCREMENT NOT NULL, potager_activite_id VARCHAR(255) NOT NULL, colonne_parcelle INT NOT NULL, ligne_parcelle INT NOT NULL, new_parcelle TINYINT(1) NOT NULL, etat_terre_parcelle VARCHAR(255) DEFAULT NULL, plantation_parcelle VARCHAR(255) DEFAULT NULL, historique1_plantation_parcelle VARCHAR(255) DEFAULT NULL, historique2_plantation_parcelle VARCHAR(255) DEFAULT NULL, historique3_plantation_parcelle VARCHAR(255) DEFAULT NULL, INDEX IDX_4F15F60E86696F99 (potager_activite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE partenaires (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, date_partenariat DATE DEFAULT NULL, email VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_D230102EE7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participants (id INT AUTO_INCREMENT NOT NULL, adherent_id INT DEFAULT NULL, email VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, is_adherent TINYINT(1) NOT NULL, type_paiement VARCHAR(255) DEFAULT NULL, is_payed TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_71697092E7927C74 (email), UNIQUE INDEX UNIQ_7169709225F06C53 (adherent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participants_events (participants_id INT NOT NULL, events_id INT NOT NULL, INDEX IDX_9E6008D8838709D5 (participants_id), INDEX IDX_9E6008D89D6A1065 (events_id), PRIMARY KEY(participants_id, events_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE potager_activite (id VARCHAR(255) NOT NULL, activite_id INT NOT NULL, description_potager_activite LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_FA84AF349B0F88B1 (activite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recoltes_fruit (id INT AUTO_INCREMENT NOT NULL, verger_activite_id VARCHAR(255) NOT NULL, date_recolte_fruit DATE DEFAULT NULL, nom_fruit_recolte VARCHAR(255) NOT NULL, nb_kg_recolte_fruit DOUBLE PRECISION NOT NULL, prix_kg_fruit DOUBLE PRECISION DEFAULT NULL, INDEX IDX_ED683682CA0C542A (verger_activite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recoltes_legume (id INT AUTO_INCREMENT NOT NULL, potager_activite_id VARCHAR(255) NOT NULL, date_recolte_legume DATE NOT NULL, nom_legume_recolte VARCHAR(255) NOT NULL, nb_kg_recolte_legume DOUBLE PRECISION DEFAULT NULL, prix_legume DOUBLE PRECISION DEFAULT NULL, INDEX IDX_EBF6F48C86696F99 (potager_activite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recoltes_miel (id INT AUTO_INCREMENT NOT NULL, rucher_id INT NOT NULL, date_recolte_miel DATE NOT NULL, nb_pots_recolte_miel INT NOT NULL, prix_pot_miel DOUBLE PRECISION DEFAULT NULL, INDEX IDX_2205FF9C8BF1374E (rucher_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE referents (id INT AUTO_INCREMENT NOT NULL, adherent_id INT NOT NULL, heures_gestion_referent INT NOT NULL, UNIQUE INDEX UNIQ_5FF478D425F06C53 (adherent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE referents_activites (referents_id INT NOT NULL, activites_id INT NOT NULL, INDEX IDX_88CA32B8B1F79D78 (referents_id), INDEX IDX_88CA32B85B8C31B7 (activites_id), PRIMARY KEY(referents_id, activites_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rucher_activite (id VARCHAR(255) NOT NULL, activite_id INT NOT NULL, description_rucher_activite LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_292172909B0F88B1 (activite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ruchers (id INT AUTO_INCREMENT NOT NULL, rucher_activite_id VARCHAR(255) NOT NULL, nom_rucher VARCHAR(255) NOT NULL, description_rucher VARCHAR(255) DEFAULT NULL, lieu_rucher LONGTEXT DEFAULT NULL, partenaire_rucher VARCHAR(255) DEFAULT NULL, date_creation_rucher DATE DEFAULT NULL, INDEX IDX_76D6246CA3276C3 (rucher_activite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ruches (id INT AUTO_INCREMENT NOT NULL, rucher_id INT NOT NULL, nom_ruche VARCHAR(255) NOT NULL, modele_ruche VARCHAR(255) NOT NULL, plancher_ruche VARCHAR(255) NOT NULL, emplacement_ruche VARCHAR(255) DEFAULT NULL, couvre_cadre_ruche VARCHAR(255) NOT NULL, toit_ruche VARCHAR(255) NOT NULL, date_installation_ruche DATE DEFAULT NULL, origine_colonie VARCHAR(255) DEFAULT NULL, date_installation_colonie DATE DEFAULT NULL, espece_colonie VARCHAR(255) DEFAULT NULL, naissance_reine DATE DEFAULT NULL, nourrisseurs VARCHAR(255) DEFAULT NULL, muselieres TINYINT(1) DEFAULT NULL, INDEX IDX_78CB1FC78BF1374E (rucher_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sachets_graines (id INT AUTO_INCREMENT NOT NULL, potager_activite_id VARCHAR(255) NOT NULL, nom_graines VARCHAR(255) NOT NULL, nb_graines INT NOT NULL, saison_plantation_graines VARCHAR(255) DEFAULT NULL, qualite_graines VARCHAR(255) DEFAULT NULL, INDEX IDX_AE06117286696F99 (potager_activite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sympathisants (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, is_int_potager TINYINT(1) NOT NULL, is_int_verger TINYINT(1) NOT NULL, is_int_rucher TINYINT(1) NOT NULL, is_int_animation TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_D5FE95B0E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE taches (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, is_done TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE taches_ateliers (taches_id INT NOT NULL, ateliers_id INT NOT NULL, INDEX IDX_9AFA2E5FB8A61670 (taches_id), INDEX IDX_9AFA2E5FB1409BC9 (ateliers_id), PRIMARY KEY(taches_id, ateliers_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE igny_valle_task (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE igny_valle_user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_998F0C10E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE verger_activite (id VARCHAR(255) NOT NULL, activite_id INT NOT NULL, description_verger_activite LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_DEEACBB19B0F88B1 (activite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE adherents_ateliers ADD CONSTRAINT FK_AFFEC26B15364D07 FOREIGN KEY (adherents_id) REFERENCES adherents (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE adherents_ateliers ADD CONSTRAINT FK_AFFEC26BB1409BC9 FOREIGN KEY (ateliers_id) REFERENCES ateliers (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE adherents_activites ADD CONSTRAINT FK_96A8C16C15364D07 FOREIGN KEY (adherents_id) REFERENCES adherents (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE adherents_activites ADD CONSTRAINT FK_96A8C16C5B8C31B7 FOREIGN KEY (activites_id) REFERENCES activites (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE admins ADD CONSTRAINT FK_A2E0150F25F06C53 FOREIGN KEY (adherent_id) REFERENCES adherents (id)');
        $this->addSql('ALTER TABLE arbres ADD CONSTRAINT FK_E6A4F221CA0C542A FOREIGN KEY (verger_activite_id) REFERENCES verger_activite (id)');
        $this->addSql('ALTER TABLE arbres ADD CONSTRAINT FK_E6A4F22125F06C53 FOREIGN KEY (adherent_id) REFERENCES adherents (id)');
        $this->addSql('ALTER TABLE ateliers ADD CONSTRAINT FK_B98805619B0F88B1 FOREIGN KEY (activite_id) REFERENCES activites (id)');
        $this->addSql('ALTER TABLE ateliers_referents ADD CONSTRAINT FK_53E967D4B1409BC9 FOREIGN KEY (ateliers_id) REFERENCES ateliers (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ateliers_referents ADD CONSTRAINT FK_53E967D4B1F79D78 FOREIGN KEY (referents_id) REFERENCES referents (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cotisations ADD CONSTRAINT FK_C51B351C25F06C53 FOREIGN KEY (adherent_id) REFERENCES adherents (id)');
        $this->addSql('ALTER TABLE emprunts ADD CONSTRAINT FK_38FC80D3ED89C80 FOREIGN KEY (outil_id) REFERENCES outils (id)');
        $this->addSql('ALTER TABLE emprunts ADD CONSTRAINT FK_38FC80D25F06C53 FOREIGN KEY (adherent_id) REFERENCES adherents (id)');
        $this->addSql('ALTER TABLE events ADD CONSTRAINT FK_5387574A98DE13AC FOREIGN KEY (partenaire_id) REFERENCES partenaires (id)');
        $this->addSql('ALTER TABLE events_admins ADD CONSTRAINT FK_705D2C3A9D6A1065 FOREIGN KEY (events_id) REFERENCES events (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE events_admins ADD CONSTRAINT FK_705D2C3AFAA286C3 FOREIGN KEY (admins_id) REFERENCES admins (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fiches_de_visite ADD CONSTRAINT FK_C40266658BF1374E FOREIGN KEY (rucher_id) REFERENCES ruchers (id)');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A7294869C FOREIGN KEY (article_id) REFERENCES articles (id)');
        $this->addSql('ALTER TABLE parcelles ADD CONSTRAINT FK_4F15F60E86696F99 FOREIGN KEY (potager_activite_id) REFERENCES potager_activite (id)');
        $this->addSql('ALTER TABLE participants ADD CONSTRAINT FK_7169709225F06C53 FOREIGN KEY (adherent_id) REFERENCES adherents (id)');
        $this->addSql('ALTER TABLE participants_events ADD CONSTRAINT FK_9E6008D8838709D5 FOREIGN KEY (participants_id) REFERENCES participants (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participants_events ADD CONSTRAINT FK_9E6008D89D6A1065 FOREIGN KEY (events_id) REFERENCES events (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE potager_activite ADD CONSTRAINT FK_FA84AF349B0F88B1 FOREIGN KEY (activite_id) REFERENCES activites (id)');
        $this->addSql('ALTER TABLE recoltes_fruit ADD CONSTRAINT FK_ED683682CA0C542A FOREIGN KEY (verger_activite_id) REFERENCES verger_activite (id)');
        $this->addSql('ALTER TABLE recoltes_legume ADD CONSTRAINT FK_EBF6F48C86696F99 FOREIGN KEY (potager_activite_id) REFERENCES potager_activite (id)');
        $this->addSql('ALTER TABLE recoltes_miel ADD CONSTRAINT FK_2205FF9C8BF1374E FOREIGN KEY (rucher_id) REFERENCES ruchers (id)');
        $this->addSql('ALTER TABLE referents ADD CONSTRAINT FK_5FF478D425F06C53 FOREIGN KEY (adherent_id) REFERENCES adherents (id)');
        $this->addSql('ALTER TABLE referents_activites ADD CONSTRAINT FK_88CA32B8B1F79D78 FOREIGN KEY (referents_id) REFERENCES referents (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE referents_activites ADD CONSTRAINT FK_88CA32B85B8C31B7 FOREIGN KEY (activites_id) REFERENCES activites (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rucher_activite ADD CONSTRAINT FK_292172909B0F88B1 FOREIGN KEY (activite_id) REFERENCES activites (id)');
        $this->addSql('ALTER TABLE ruchers ADD CONSTRAINT FK_76D6246CA3276C3 FOREIGN KEY (rucher_activite_id) REFERENCES rucher_activite (id)');
        $this->addSql('ALTER TABLE ruches ADD CONSTRAINT FK_78CB1FC78BF1374E FOREIGN KEY (rucher_id) REFERENCES ruchers (id)');
        $this->addSql('ALTER TABLE sachets_graines ADD CONSTRAINT FK_AE06117286696F99 FOREIGN KEY (potager_activite_id) REFERENCES potager_activite (id)');
        $this->addSql('ALTER TABLE taches_ateliers ADD CONSTRAINT FK_9AFA2E5FB8A61670 FOREIGN KEY (taches_id) REFERENCES taches (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE taches_ateliers ADD CONSTRAINT FK_9AFA2E5FB1409BC9 FOREIGN KEY (ateliers_id) REFERENCES ateliers (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE verger_activite ADD CONSTRAINT FK_DEEACBB19B0F88B1 FOREIGN KEY (activite_id) REFERENCES activites (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE adherents_activites DROP FOREIGN KEY FK_96A8C16C5B8C31B7');
        $this->addSql('ALTER TABLE ateliers DROP FOREIGN KEY FK_B98805619B0F88B1');
        $this->addSql('ALTER TABLE potager_activite DROP FOREIGN KEY FK_FA84AF349B0F88B1');
        $this->addSql('ALTER TABLE referents_activites DROP FOREIGN KEY FK_88CA32B85B8C31B7');
        $this->addSql('ALTER TABLE rucher_activite DROP FOREIGN KEY FK_292172909B0F88B1');
        $this->addSql('ALTER TABLE verger_activite DROP FOREIGN KEY FK_DEEACBB19B0F88B1');
        $this->addSql('ALTER TABLE adherents_ateliers DROP FOREIGN KEY FK_AFFEC26B15364D07');
        $this->addSql('ALTER TABLE adherents_activites DROP FOREIGN KEY FK_96A8C16C15364D07');
        $this->addSql('ALTER TABLE admins DROP FOREIGN KEY FK_A2E0150F25F06C53');
        $this->addSql('ALTER TABLE arbres DROP FOREIGN KEY FK_E6A4F22125F06C53');
        $this->addSql('ALTER TABLE cotisations DROP FOREIGN KEY FK_C51B351C25F06C53');
        $this->addSql('ALTER TABLE emprunts DROP FOREIGN KEY FK_38FC80D25F06C53');
        $this->addSql('ALTER TABLE participants DROP FOREIGN KEY FK_7169709225F06C53');
        $this->addSql('ALTER TABLE referents DROP FOREIGN KEY FK_5FF478D425F06C53');
        $this->addSql('ALTER TABLE events_admins DROP FOREIGN KEY FK_705D2C3AFAA286C3');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A7294869C');
        $this->addSql('ALTER TABLE adherents_ateliers DROP FOREIGN KEY FK_AFFEC26BB1409BC9');
        $this->addSql('ALTER TABLE ateliers_referents DROP FOREIGN KEY FK_53E967D4B1409BC9');
        $this->addSql('ALTER TABLE taches_ateliers DROP FOREIGN KEY FK_9AFA2E5FB1409BC9');
        $this->addSql('ALTER TABLE events_admins DROP FOREIGN KEY FK_705D2C3A9D6A1065');
        $this->addSql('ALTER TABLE participants_events DROP FOREIGN KEY FK_9E6008D89D6A1065');
        $this->addSql('ALTER TABLE emprunts DROP FOREIGN KEY FK_38FC80D3ED89C80');
        $this->addSql('ALTER TABLE events DROP FOREIGN KEY FK_5387574A98DE13AC');
        $this->addSql('ALTER TABLE participants_events DROP FOREIGN KEY FK_9E6008D8838709D5');
        $this->addSql('ALTER TABLE parcelles DROP FOREIGN KEY FK_4F15F60E86696F99');
        $this->addSql('ALTER TABLE recoltes_legume DROP FOREIGN KEY FK_EBF6F48C86696F99');
        $this->addSql('ALTER TABLE sachets_graines DROP FOREIGN KEY FK_AE06117286696F99');
        $this->addSql('ALTER TABLE ateliers_referents DROP FOREIGN KEY FK_53E967D4B1F79D78');
        $this->addSql('ALTER TABLE referents_activites DROP FOREIGN KEY FK_88CA32B8B1F79D78');
        $this->addSql('ALTER TABLE ruchers DROP FOREIGN KEY FK_76D6246CA3276C3');
        $this->addSql('ALTER TABLE fiches_de_visite DROP FOREIGN KEY FK_C40266658BF1374E');
        $this->addSql('ALTER TABLE recoltes_miel DROP FOREIGN KEY FK_2205FF9C8BF1374E');
        $this->addSql('ALTER TABLE ruches DROP FOREIGN KEY FK_78CB1FC78BF1374E');
        $this->addSql('ALTER TABLE taches_ateliers DROP FOREIGN KEY FK_9AFA2E5FB8A61670');
        $this->addSql('ALTER TABLE arbres DROP FOREIGN KEY FK_E6A4F221CA0C542A');
        $this->addSql('ALTER TABLE recoltes_fruit DROP FOREIGN KEY FK_ED683682CA0C542A');
        $this->addSql('DROP TABLE activites');
        $this->addSql('DROP TABLE adherents');
        $this->addSql('DROP TABLE adherents_ateliers');
        $this->addSql('DROP TABLE adherents_activites');
        $this->addSql('DROP TABLE admins');
        $this->addSql('DROP TABLE arbres');
        $this->addSql('DROP TABLE articles');
        $this->addSql('DROP TABLE ateliers');
        $this->addSql('DROP TABLE ateliers_referents');
        $this->addSql('DROP TABLE cotisations');
        $this->addSql('DROP TABLE emprunts');
        $this->addSql('DROP TABLE events');
        $this->addSql('DROP TABLE events_admins');
        $this->addSql('DROP TABLE fiches_de_visite');
        $this->addSql('DROP TABLE images');
        $this->addSql('DROP TABLE outils');
        $this->addSql('DROP TABLE parcelles');
        $this->addSql('DROP TABLE partenaires');
        $this->addSql('DROP TABLE participants');
        $this->addSql('DROP TABLE participants_events');
        $this->addSql('DROP TABLE potager_activite');
        $this->addSql('DROP TABLE recoltes_fruit');
        $this->addSql('DROP TABLE recoltes_legume');
        $this->addSql('DROP TABLE recoltes_miel');
        $this->addSql('DROP TABLE referents');
        $this->addSql('DROP TABLE referents_activites');
        $this->addSql('DROP TABLE rucher_activite');
        $this->addSql('DROP TABLE ruchers');
        $this->addSql('DROP TABLE ruches');
        $this->addSql('DROP TABLE sachets_graines');
        $this->addSql('DROP TABLE sympathisants');
        $this->addSql('DROP TABLE taches');
        $this->addSql('DROP TABLE taches_ateliers');
        $this->addSql('DROP TABLE igny_valle_task');
        $this->addSql('DROP TABLE igny_valle_user');
        $this->addSql('DROP TABLE verger_activite');
    }
}
