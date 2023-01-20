<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230120090529 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cadre (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE certificat (id INT AUTO_INCREMENT NOT NULL, specialite_id INT DEFAULT NULL, pathologie_id INT DEFAULT NULL, user_id INT DEFAULT NULL, avis_traitant LONGTEXT DEFAULT NULL, plainte_doleance LONGTEXT DEFAULT NULL, examen_clinique LONGTEXT DEFAULT NULL, avis_medecin_conseil LONGTEXT DEFAULT NULL, examens_complementaires LONGTEXT DEFAULT NULL, expertise_demandee LONGTEXT DEFAULT NULL, medecin VARCHAR(255) DEFAULT NULL, INDEX IDX_27448F772195E0F0 (specialite_id), INDEX IDX_27448F77E7F789D4 (pathologie_id), INDEX IDX_27448F77A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE conseil (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, date_conseil DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE conseil_patient (conseil_id INT NOT NULL, patient_id INT NOT NULL, INDEX IDX_448E1CC7668A3E03 (conseil_id), INDEX IDX_448E1CC76B899279 (patient_id), PRIMARY KEY(conseil_id, patient_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE corps (id INT AUTO_INCREMENT NOT NULL, cadre_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_CAB3F89B9308DA90 (cadre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE demande (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE devise (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(20) NOT NULL, tau DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evasan (id INT AUTO_INCREMENT NOT NULL, questionnaire_id INT DEFAULT NULL, devise_id INT DEFAULT NULL, accompagnant VARCHAR(255) DEFAULT NULL, destination VARCHAR(255) DEFAULT NULL, montant DOUBLE PRECISION DEFAULT NULL, date_depart DATE DEFAULT NULL, date_retour DATE DEFAULT NULL, frais_hospitalisation_soins DOUBLE PRECISION DEFAULT NULL, rv_controle VARCHAR(255) DEFAULT NULL, date_demande DATE DEFAULT NULL, n_bordereau_ministere_tutelle VARCHAR(255) DEFAULT NULL, n_date_decision VARCHAR(255) DEFAULT NULL, n_facture_date_transmission_solde VARCHAR(255) DEFAULT NULL, date_virement DATE DEFAULT NULL, n_tresor VARCHAR(255) DEFAULT NULL, tau VARCHAR(10) DEFAULT NULL, facture_pro_format DOUBLE PRECISION DEFAULT NULL, facture_definitive DOUBLE PRECISION DEFAULT NULL, UNIQUE INDEX UNIQ_9CA87AF3CE07E8FF (questionnaire_id), INDEX IDX_9CA87AF3F4445056 (devise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ministere (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pathologie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patient (id INT AUTO_INCREMENT NOT NULL, tutel_id INT DEFAULT NULL, corps_id INT DEFAULT NULL, cadre_id INT DEFAULT NULL, prenom VARCHAR(50) NOT NULL, nom VARCHAR(50) NOT NULL, date_naissance DATE NOT NULL, lieu_naissance VARCHAR(100) NOT NULL, matricule VARCHAR(7) NOT NULL, lieu_service VARCHAR(255) NOT NULL, date_entree_service DATE NOT NULL, nombre_enfant INT NOT NULL, adresse VARCHAR(255) NOT NULL, telephone_bureau VARCHAR(15) DEFAULT NULL, telephone_personnel VARCHAR(15) DEFAULT NULL, situation_matrimoniale INT NOT NULL, grade INT NOT NULL, sexe INT NOT NULL, INDEX IDX_1ADAD7EBDAF95CFC (tutel_id), INDEX IDX_1ADAD7EB190A1B68 (corps_id), INDEX IDX_1ADAD7EB9308DA90 (cadre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questionnaire (id INT AUTO_INCREMENT NOT NULL, q8_id INT DEFAULT NULL, patient_id INT NOT NULL, certificat_id INT DEFAULT NULL, conseil_id INT DEFAULT NULL, q1 TINYINT(1) NOT NULL, q2autre LONGTEXT DEFAULT NULL, q3 TINYINT(1) NOT NULL, q4 TINYINT(1) NOT NULL, q4datesuspension DATE DEFAULT NULL, q3datecessation DATE DEFAULT NULL, q5 LONGTEXT NOT NULL, q6 LONGTEXT NOT NULL, q7 LONGTEXT NOT NULL, demande_traduction VARCHAR(255) NOT NULL, date_conseil DATE DEFAULT NULL, decision_conseil LONGTEXT DEFAULT NULL, numero_certificat VARCHAR(255) DEFAULT NULL, date_transmission_resultat DATE DEFAULT NULL, numero_bordereau VARCHAR(255) DEFAULT NULL, lieu_de_rapprochement VARCHAR(255) DEFAULT NULL, INDEX IDX_7A64DAFAE0FF20E (q8_id), INDEX IDX_7A64DAF6B899279 (patient_id), UNIQUE INDEX UNIQ_7A64DAFFA55BACF (certificat_id), INDEX IDX_7A64DAF668A3E03 (conseil_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questionnaire_demande (questionnaire_id INT NOT NULL, demande_id INT NOT NULL, INDEX IDX_7908F9A2CE07E8FF (questionnaire_id), INDEX IDX_7908F9A280E95E18 (demande_id), PRIMARY KEY(questionnaire_id, demande_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE souhait (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE specialite (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom_complet VARCHAR(255) DEFAULT NULL, medecin_chef TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE visa (id INT AUTO_INCREMENT NOT NULL, visa LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE certificat ADD CONSTRAINT FK_27448F772195E0F0 FOREIGN KEY (specialite_id) REFERENCES specialite (id)');
        $this->addSql('ALTER TABLE certificat ADD CONSTRAINT FK_27448F77E7F789D4 FOREIGN KEY (pathologie_id) REFERENCES pathologie (id)');
        $this->addSql('ALTER TABLE certificat ADD CONSTRAINT FK_27448F77A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE conseil_patient ADD CONSTRAINT FK_448E1CC7668A3E03 FOREIGN KEY (conseil_id) REFERENCES conseil (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE conseil_patient ADD CONSTRAINT FK_448E1CC76B899279 FOREIGN KEY (patient_id) REFERENCES patient (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE corps ADD CONSTRAINT FK_CAB3F89B9308DA90 FOREIGN KEY (cadre_id) REFERENCES cadre (id)');
        $this->addSql('ALTER TABLE evasan ADD CONSTRAINT FK_9CA87AF3CE07E8FF FOREIGN KEY (questionnaire_id) REFERENCES questionnaire (id)');
        $this->addSql('ALTER TABLE evasan ADD CONSTRAINT FK_9CA87AF3F4445056 FOREIGN KEY (devise_id) REFERENCES devise (id)');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EBDAF95CFC FOREIGN KEY (tutel_id) REFERENCES ministere (id)');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EB190A1B68 FOREIGN KEY (corps_id) REFERENCES corps (id)');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EB9308DA90 FOREIGN KEY (cadre_id) REFERENCES cadre (id)');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAFAE0FF20E FOREIGN KEY (q8_id) REFERENCES souhait (id)');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAF6B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAFFA55BACF FOREIGN KEY (certificat_id) REFERENCES certificat (id)');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAF668A3E03 FOREIGN KEY (conseil_id) REFERENCES conseil (id)');
        $this->addSql('ALTER TABLE questionnaire_demande ADD CONSTRAINT FK_7908F9A2CE07E8FF FOREIGN KEY (questionnaire_id) REFERENCES questionnaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE questionnaire_demande ADD CONSTRAINT FK_7908F9A280E95E18 FOREIGN KEY (demande_id) REFERENCES demande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE corps DROP FOREIGN KEY FK_CAB3F89B9308DA90');
        $this->addSql('ALTER TABLE patient DROP FOREIGN KEY FK_1ADAD7EB9308DA90');
        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAFFA55BACF');
        $this->addSql('ALTER TABLE conseil_patient DROP FOREIGN KEY FK_448E1CC7668A3E03');
        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAF668A3E03');
        $this->addSql('ALTER TABLE patient DROP FOREIGN KEY FK_1ADAD7EB190A1B68');
        $this->addSql('ALTER TABLE questionnaire_demande DROP FOREIGN KEY FK_7908F9A280E95E18');
        $this->addSql('ALTER TABLE evasan DROP FOREIGN KEY FK_9CA87AF3F4445056');
        $this->addSql('ALTER TABLE patient DROP FOREIGN KEY FK_1ADAD7EBDAF95CFC');
        $this->addSql('ALTER TABLE certificat DROP FOREIGN KEY FK_27448F77E7F789D4');
        $this->addSql('ALTER TABLE conseil_patient DROP FOREIGN KEY FK_448E1CC76B899279');
        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAF6B899279');
        $this->addSql('ALTER TABLE evasan DROP FOREIGN KEY FK_9CA87AF3CE07E8FF');
        $this->addSql('ALTER TABLE questionnaire_demande DROP FOREIGN KEY FK_7908F9A2CE07E8FF');
        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAFAE0FF20E');
        $this->addSql('ALTER TABLE certificat DROP FOREIGN KEY FK_27448F772195E0F0');
        $this->addSql('ALTER TABLE certificat DROP FOREIGN KEY FK_27448F77A76ED395');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('DROP TABLE cadre');
        $this->addSql('DROP TABLE certificat');
        $this->addSql('DROP TABLE conseil');
        $this->addSql('DROP TABLE conseil_patient');
        $this->addSql('DROP TABLE corps');
        $this->addSql('DROP TABLE demande');
        $this->addSql('DROP TABLE devise');
        $this->addSql('DROP TABLE evasan');
        $this->addSql('DROP TABLE ministere');
        $this->addSql('DROP TABLE pathologie');
        $this->addSql('DROP TABLE patient');
        $this->addSql('DROP TABLE questionnaire');
        $this->addSql('DROP TABLE questionnaire_demande');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE souhait');
        $this->addSql('DROP TABLE specialite');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE visa');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
