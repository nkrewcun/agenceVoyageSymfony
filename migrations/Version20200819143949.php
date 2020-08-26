<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200819143949 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE activite (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE activite_sejour (activite_id INT NOT NULL, sejour_id INT NOT NULL, INDEX IDX_EF97E44C9B0F88B1 (activite_id), INDEX IDX_EF97E44C84CF0CF (sejour_id), PRIMARY KEY(activite_id, sejour_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE destination (id INT AUTO_INCREMENT NOT NULL, sejour_id INT NOT NULL, lieu VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, pays VARCHAR(255) NOT NULL, date_ouverture DATE DEFAULT NULL, nb_star INT NOT NULL, UNIQUE INDEX UNIQ_3EC63EAA84CF0CF (sejour_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sejour (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, type_logement VARCHAR(255) NOT NULL, nb_personne INT NOT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_96F5202812469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE activite_sejour ADD CONSTRAINT FK_EF97E44C9B0F88B1 FOREIGN KEY (activite_id) REFERENCES activite (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE activite_sejour ADD CONSTRAINT FK_EF97E44C84CF0CF FOREIGN KEY (sejour_id) REFERENCES sejour (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE destination ADD CONSTRAINT FK_3EC63EAA84CF0CF FOREIGN KEY (sejour_id) REFERENCES sejour (id)');
        $this->addSql('ALTER TABLE sejour ADD CONSTRAINT FK_96F5202812469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activite_sejour DROP FOREIGN KEY FK_EF97E44C9B0F88B1');
        $this->addSql('ALTER TABLE sejour DROP FOREIGN KEY FK_96F5202812469DE2');
        $this->addSql('ALTER TABLE activite_sejour DROP FOREIGN KEY FK_EF97E44C84CF0CF');
        $this->addSql('ALTER TABLE destination DROP FOREIGN KEY FK_3EC63EAA84CF0CF');
        $this->addSql('DROP TABLE activite');
        $this->addSql('DROP TABLE activite_sejour');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE destination');
        $this->addSql('DROP TABLE sejour');
    }
}
