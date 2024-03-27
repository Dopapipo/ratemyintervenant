<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240327105231 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE intervenant_classe (intervenant_id INT NOT NULL, classe_id INT NOT NULL, INDEX IDX_FAF9EB70AB9A1716 (intervenant_id), INDEX IDX_FAF9EB708F5EA509 (classe_id), PRIMARY KEY(intervenant_id, classe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE intervenant_classe ADD CONSTRAINT FK_FAF9EB70AB9A1716 FOREIGN KEY (intervenant_id) REFERENCES intervenant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE intervenant_classe ADD CONSTRAINT FK_FAF9EB708F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE classe_intervenant DROP FOREIGN KEY FK_DFC9D6FD8F5EA509');
        $this->addSql('ALTER TABLE classe_intervenant DROP FOREIGN KEY FK_DFC9D6FDAB9A1716');
        $this->addSql('DROP TABLE classe_intervenant');
        $this->addSql('ALTER TABLE matiere CHANGE intervenant_id intervenant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD is_verified TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE classe_intervenant (classe_id INT NOT NULL, intervenant_id INT NOT NULL, INDEX IDX_DFC9D6FDAB9A1716 (intervenant_id), INDEX IDX_DFC9D6FD8F5EA509 (classe_id), PRIMARY KEY(classe_id, intervenant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE classe_intervenant ADD CONSTRAINT FK_DFC9D6FD8F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE classe_intervenant ADD CONSTRAINT FK_DFC9D6FDAB9A1716 FOREIGN KEY (intervenant_id) REFERENCES intervenant (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE intervenant_classe DROP FOREIGN KEY FK_FAF9EB70AB9A1716');
        $this->addSql('ALTER TABLE intervenant_classe DROP FOREIGN KEY FK_FAF9EB708F5EA509');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('DROP TABLE intervenant_classe');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('ALTER TABLE matiere CHANGE intervenant_id intervenant_id INT NOT NULL');
        $this->addSql('ALTER TABLE user DROP is_verified');
    }
}
