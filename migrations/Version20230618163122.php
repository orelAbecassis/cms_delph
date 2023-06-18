<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230618163122 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fichier DROP date_fichier');
        $this->addSql('ALTER TABLE fichier_demande ADD id_fichier_id INT DEFAULT NULL, CHANGE nom_fichier nom_fichier VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE fichier_demande ADD CONSTRAINT FK_FD072B92AA1BDC29 FOREIGN KEY (id_fichier_id) REFERENCES fichier (id)');
        $this->addSql('CREATE INDEX IDX_FD072B92AA1BDC29 ON fichier_demande (id_fichier_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fichier ADD date_fichier DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE fichier_demande DROP FOREIGN KEY FK_FD072B92AA1BDC29');
        $this->addSql('DROP INDEX IDX_FD072B92AA1BDC29 ON fichier_demande');
        $this->addSql('ALTER TABLE fichier_demande DROP id_fichier_id, CHANGE nom_fichier nom_fichier VARCHAR(255) NOT NULL');
    }
}
