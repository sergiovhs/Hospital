<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250303101924 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE servicio (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE texto (id INT AUTO_INCREMENT NOT NULL, servicio_id INT DEFAULT NULL, texto VARCHAR(255) NOT NULL, orden INT NOT NULL, INDEX IDX_A344FF071CAA3E7 (servicio_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE texto ADD CONSTRAINT FK_A344FF071CAA3E7 FOREIGN KEY (servicio_id) REFERENCES servicio (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE texto DROP FOREIGN KEY FK_A344FF071CAA3E7');
        $this->addSql('DROP TABLE servicio');
        $this->addSql('DROP TABLE texto');
    }
}
