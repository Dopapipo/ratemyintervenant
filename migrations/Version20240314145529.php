<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240314145529 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE makeadminview ADD classe_id INT NOT NULL, DROP class');
        $this->addSql('ALTER TABLE makeadminview ADD CONSTRAINT FK_8D93D6498F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6498F5EA509 ON makeadminview (classe_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `makeadminview` DROP FOREIGN KEY FK_8D93D6498F5EA509');
        $this->addSql('DROP INDEX IDX_8D93D6498F5EA509 ON `makeadminview`');
        $this->addSql('ALTER TABLE `makeadminview` ADD class VARCHAR(255) NOT NULL, DROP classe_id');
    }
}
