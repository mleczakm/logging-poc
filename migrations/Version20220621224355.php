<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220621224355 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE customer (id UUID NOT NULL, department_id UUID NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, payout NUMERIC(10, 0) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_81398E09AE80F5DF ON customer (department_id)');
        $this->addSql('COMMENT ON COLUMN customer.id IS \'(DC2Type:ulid)\'');
        $this->addSql('COMMENT ON COLUMN customer.department_id IS \'(DC2Type:ulid)\'');
        $this->addSql('CREATE TABLE department (id UUID NOT NULL, name VARCHAR(255) NOT NULL, strategy JSONB NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN department.id IS \'(DC2Type:ulid)\'');
        $this->addSql('COMMENT ON COLUMN department.strategy IS \'(DC2Type:json_document)\'');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09AE80F5DF FOREIGN KEY (department_id) REFERENCES department (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE customer DROP CONSTRAINT FK_81398E09AE80F5DF');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE department');
    }
}
