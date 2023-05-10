<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230510080313 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE developer_technology (developer_id INT NOT NULL, technology_id INT NOT NULL, INDEX IDX_3EDD0A8B64DD9267 (developer_id), INDEX IDX_3EDD0A8B4235D463 (technology_id), PRIMARY KEY(developer_id, technology_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE general_category (id INT AUTO_INCREMENT NOT NULL, gen_cat_name VARCHAR(150) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE language (id INT AUTO_INCREMENT NOT NULL, native_lang VARCHAR(50) NOT NULL, other_lang VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tech_category (id INT AUTO_INCREMENT NOT NULL, tech_cat_name VARCHAR(150) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE technology (id INT AUTO_INCREMENT NOT NULL, tech_name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE developer_technology ADD CONSTRAINT FK_3EDD0A8B64DD9267 FOREIGN KEY (developer_id) REFERENCES developer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE developer_technology ADD CONSTRAINT FK_3EDD0A8B4235D463 FOREIGN KEY (technology_id) REFERENCES technology (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE developer ADD experience_id INT DEFAULT NULL, ADD language_id INT NOT NULL');
        $this->addSql('ALTER TABLE developer ADD CONSTRAINT FK_65FB8B9A46E90E27 FOREIGN KEY (experience_id) REFERENCES experience (id)');
        $this->addSql('ALTER TABLE developer ADD CONSTRAINT FK_65FB8B9A82F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id)');
        $this->addSql('CREATE INDEX IDX_65FB8B9A46E90E27 ON developer (experience_id)');
        $this->addSql('CREATE INDEX IDX_65FB8B9A82F1BAF4 ON developer (language_id)');
        $this->addSql('ALTER TABLE experience DROP FOREIGN KEY FK_590C10364DD9267');
        $this->addSql('DROP INDEX IDX_590C10364DD9267 ON experience');
        $this->addSql('ALTER TABLE experience DROP developer_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE developer DROP FOREIGN KEY FK_65FB8B9A82F1BAF4');
        $this->addSql('ALTER TABLE developer_technology DROP FOREIGN KEY FK_3EDD0A8B64DD9267');
        $this->addSql('ALTER TABLE developer_technology DROP FOREIGN KEY FK_3EDD0A8B4235D463');
        $this->addSql('DROP TABLE developer_technology');
        $this->addSql('DROP TABLE general_category');
        $this->addSql('DROP TABLE language');
        $this->addSql('DROP TABLE tech_category');
        $this->addSql('DROP TABLE technology');
        $this->addSql('ALTER TABLE developer DROP FOREIGN KEY FK_65FB8B9A46E90E27');
        $this->addSql('DROP INDEX IDX_65FB8B9A46E90E27 ON developer');
        $this->addSql('DROP INDEX IDX_65FB8B9A82F1BAF4 ON developer');
        $this->addSql('ALTER TABLE developer DROP experience_id, DROP language_id');
        $this->addSql('ALTER TABLE experience ADD developer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE experience ADD CONSTRAINT FK_590C10364DD9267 FOREIGN KEY (developer_id) REFERENCES developer (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_590C10364DD9267 ON experience (developer_id)');
    }
}
