<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240314100840 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE process_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE worker_machine_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE process (id INT NOT NULL, machine_id_id INT DEFAULT NULL, memory_required INT NOT NULL, cpu_required INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_861D189656CB5D24 ON process (machine_id_id)');
        $this->addSql('CREATE TABLE worker_machine (id INT NOT NULL, memory_total INT NOT NULL, cpu_total INT NOT NULL, memory_available INT NOT NULL, cpu_available INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE process ADD CONSTRAINT FK_861D189656CB5D24 FOREIGN KEY (machine_id_id) REFERENCES worker_machine (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE process_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE worker_machine_id_seq CASCADE');
        $this->addSql('ALTER TABLE process DROP CONSTRAINT FK_861D189656CB5D24');
        $this->addSql('DROP TABLE process');
        $this->addSql('DROP TABLE worker_machine');
    }
}
