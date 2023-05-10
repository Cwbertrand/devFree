<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230510074352 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE speciality_developer DROP FOREIGN KEY FK_6D41CE983B5A08D7');
        $this->addSql('ALTER TABLE speciality_developer DROP FOREIGN KEY FK_6D41CE9864DD9267');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE speciality_developer');
        $this->addSql('DROP TABLE lang_speciality');
        $this->addSql('DROP TABLE speciality');
        $this->addSql('ALTER TABLE developer DROP native_language, DROP other_languages');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name_category VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE speciality_developer (speciality_id INT NOT NULL, developer_id INT NOT NULL, INDEX IDX_6D41CE983B5A08D7 (speciality_id), INDEX IDX_6D41CE9864DD9267 (developer_id), PRIMARY KEY(speciality_id, developer_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE lang_speciality (id INT AUTO_INCREMENT NOT NULL, lang_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE speciality (id INT AUTO_INCREMENT NOT NULL, name_speciality VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE speciality_developer ADD CONSTRAINT FK_6D41CE983B5A08D7 FOREIGN KEY (speciality_id) REFERENCES speciality (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE speciality_developer ADD CONSTRAINT FK_6D41CE9864DD9267 FOREIGN KEY (developer_id) REFERENCES developer (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE developer ADD native_language VARCHAR(255) NOT NULL, ADD other_languages JSON DEFAULT NULL');
    }
}
