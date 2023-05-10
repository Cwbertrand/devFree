<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230503114620 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE speciality_developer (speciality_id INT NOT NULL, developer_id INT NOT NULL, INDEX IDX_6D41CE983B5A08D7 (speciality_id), INDEX IDX_6D41CE9864DD9267 (developer_id), PRIMARY KEY(speciality_id, developer_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE speciality_developer ADD CONSTRAINT FK_6D41CE983B5A08D7 FOREIGN KEY (speciality_id) REFERENCES speciality (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE speciality_developer ADD CONSTRAINT FK_6D41CE9864DD9267 FOREIGN KEY (developer_id) REFERENCES developer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE developer ADD image VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE experience ADD developer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE experience ADD CONSTRAINT FK_590C10364DD9267 FOREIGN KEY (developer_id) REFERENCES developer (id)');
        $this->addSql('CREATE INDEX IDX_590C10364DD9267 ON experience (developer_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE speciality_developer DROP FOREIGN KEY FK_6D41CE983B5A08D7');
        $this->addSql('ALTER TABLE speciality_developer DROP FOREIGN KEY FK_6D41CE9864DD9267');
        $this->addSql('DROP TABLE speciality_developer');
        $this->addSql('ALTER TABLE developer DROP image');
        $this->addSql('ALTER TABLE experience DROP FOREIGN KEY FK_590C10364DD9267');
        $this->addSql('DROP INDEX IDX_590C10364DD9267 ON experience');
        $this->addSql('ALTER TABLE experience DROP developer_id');
    }
}
