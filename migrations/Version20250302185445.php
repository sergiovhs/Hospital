<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250302185445 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE especialidad (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medicos (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medicos_especialidad (medicos_id INT NOT NULL, especialidad_id INT NOT NULL, INDEX IDX_5418DF79EE600A12 (medicos_id), INDEX IDX_5418DF7916A490EC (especialidad_id), PRIMARY KEY(medicos_id, especialidad_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE medicos_especialidad ADD CONSTRAINT FK_5418DF79EE600A12 FOREIGN KEY (medicos_id) REFERENCES medicos (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE medicos_especialidad ADD CONSTRAINT FK_5418DF7916A490EC FOREIGN KEY (especialidad_id) REFERENCES especialidad (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE medicos_especialidad DROP FOREIGN KEY FK_5418DF79EE600A12');
        $this->addSql('ALTER TABLE medicos_especialidad DROP FOREIGN KEY FK_5418DF7916A490EC');
        $this->addSql('DROP TABLE especialidad');
        $this->addSql('DROP TABLE medicos');
        $this->addSql('DROP TABLE medicos_especialidad');
    }
}
