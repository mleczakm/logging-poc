<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220624040731 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE "user" (id UUID NOT NULL, department_id UUID NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, payout NUMERIC(10, 0) NOT NULL, seniority INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8D93D649AE80F5DF ON "user" (department_id)');
        $this->addSql('COMMENT ON COLUMN "user".id IS \'(DC2Type:ulid)\'');
        $this->addSql('COMMENT ON COLUMN "user".department_id IS \'(DC2Type:ulid)\'');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D649AE80F5DF FOREIGN KEY (department_id) REFERENCES department (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE customer');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE customer (id UUID NOT NULL, department_id UUID NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, payout NUMERIC(10, 0) NOT NULL, seniority INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_81398e09ae80f5df ON customer (department_id)');
        $this->addSql('COMMENT ON COLUMN customer.id IS \'(DC2Type:ulid)\'');
        $this->addSql('COMMENT ON COLUMN customer.department_id IS \'(DC2Type:ulid)\'');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT fk_81398e09ae80f5df FOREIGN KEY (department_id) REFERENCES department (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE "user"');
    }
}
