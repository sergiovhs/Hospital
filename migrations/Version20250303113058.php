<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250303113058 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE encuesta (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pregunta (id INT AUTO_INCREMENT NOT NULL, encuesta_id INT DEFAULT NULL, pregunta VARCHAR(255) NOT NULL, orden INT NOT NULL, INDEX IDX_AEE0E1F746844BA6 (encuesta_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE respuesta (id INT AUTO_INCREMENT NOT NULL, pregunta_id INT DEFAULT NULL, respuesta VARCHAR(255) NOT NULL, orden INT NOT NULL, INDEX IDX_6C6EC5EE31A5801E (pregunta_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resultado (id INT AUTO_INCREMENT NOT NULL, respuesta_id INT DEFAULT NULL, INDEX IDX_B2ED91CD9BA57A2 (respuesta_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pregunta ADD CONSTRAINT FK_AEE0E1F746844BA6 FOREIGN KEY (encuesta_id) REFERENCES encuesta (id)');
        $this->addSql('ALTER TABLE respuesta ADD CONSTRAINT FK_6C6EC5EE31A5801E FOREIGN KEY (pregunta_id) REFERENCES pregunta (id)');
        $this->addSql('ALTER TABLE resultado ADD CONSTRAINT FK_B2ED91CD9BA57A2 FOREIGN KEY (respuesta_id) REFERENCES respuesta (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pregunta DROP FOREIGN KEY FK_AEE0E1F746844BA6');
        $this->addSql('ALTER TABLE respuesta DROP FOREIGN KEY FK_6C6EC5EE31A5801E');
        $this->addSql('ALTER TABLE resultado DROP FOREIGN KEY FK_B2ED91CD9BA57A2');
        $this->addSql('DROP TABLE encuesta');
        $this->addSql('DROP TABLE pregunta');
        $this->addSql('DROP TABLE respuesta');
        $this->addSql('DROP TABLE resultado');
    }
}
