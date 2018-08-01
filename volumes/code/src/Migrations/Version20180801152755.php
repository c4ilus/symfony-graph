<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180801152755 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE style_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE band_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE style (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE band (id INT NOT NULL, name VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE band_style (band_id INT NOT NULL, style_id INT NOT NULL, PRIMARY KEY(band_id, style_id))');
        $this->addSql('CREATE INDEX IDX_CF5F06F649ABEB17 ON band_style (band_id)');
        $this->addSql('CREATE INDEX IDX_CF5F06F6BACD6074 ON band_style (style_id)');
        $this->addSql('ALTER TABLE band_style ADD CONSTRAINT FK_CF5F06F649ABEB17 FOREIGN KEY (band_id) REFERENCES band (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE band_style ADD CONSTRAINT FK_CF5F06F6BACD6074 FOREIGN KEY (style_id) REFERENCES style (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE band_style DROP CONSTRAINT FK_CF5F06F6BACD6074');
        $this->addSql('ALTER TABLE band_style DROP CONSTRAINT FK_CF5F06F649ABEB17');
        $this->addSql('DROP SEQUENCE style_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE band_id_seq CASCADE');
        $this->addSql('DROP TABLE style');
        $this->addSql('DROP TABLE band');
        $this->addSql('DROP TABLE band_style');
    }
}
