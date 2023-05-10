<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230510095555 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE technology_tech_category (technology_id INT NOT NULL, tech_category_id INT NOT NULL, INDEX IDX_565858924235D463 (technology_id), INDEX IDX_565858925370511 (tech_category_id), PRIMARY KEY(technology_id, tech_category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE technology_tech_category ADD CONSTRAINT FK_565858924235D463 FOREIGN KEY (technology_id) REFERENCES technology (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE technology_tech_category ADD CONSTRAINT FK_565858925370511 FOREIGN KEY (tech_category_id) REFERENCES tech_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tech_category ADD gen_cat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tech_category ADD CONSTRAINT FK_4BB73A81D690A3 FOREIGN KEY (gen_cat_id) REFERENCES general_category (id)');
        $this->addSql('CREATE INDEX IDX_4BB73A81D690A3 ON tech_category (gen_cat_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE technology_tech_category DROP FOREIGN KEY FK_565858924235D463');
        $this->addSql('ALTER TABLE technology_tech_category DROP FOREIGN KEY FK_565858925370511');
        $this->addSql('DROP TABLE technology_tech_category');
        $this->addSql('ALTER TABLE tech_category DROP FOREIGN KEY FK_4BB73A81D690A3');
        $this->addSql('DROP INDEX IDX_4BB73A81D690A3 ON tech_category');
        $this->addSql('ALTER TABLE tech_category DROP gen_cat_id');
    }
}
