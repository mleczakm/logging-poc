<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220624013909 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE customer ADD seniority INT NOT NULL');
        $this->addSql('ALTER TABLE customer ALTER payout TYPE NUMERIC(10, 0)');
        $this->addSql('ALTER TABLE customer ALTER payout DROP DEFAULT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE customer DROP seniority');
        $this->addSql('ALTER TABLE customer ALTER payout TYPE NUMERIC(10, 0)');
        $this->addSql('ALTER TABLE customer ALTER payout DROP DEFAULT');
    }
}
