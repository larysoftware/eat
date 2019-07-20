<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190720200046 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE customers DROP FOREIGN KEY FK_62534E21F373DCF');
        $this->addSql('DROP TABLE groups');
        $this->addSql('DROP INDEX IDX_62534E21F373DCF ON customers');
        $this->addSql('ALTER TABLE customers DROP groups_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE groups (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE customers ADD groups_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE customers ADD CONSTRAINT FK_62534E21F373DCF FOREIGN KEY (groups_id) REFERENCES groups (id)');
        $this->addSql('CREATE INDEX IDX_62534E21F373DCF ON customers (groups_id)');
    }
}
