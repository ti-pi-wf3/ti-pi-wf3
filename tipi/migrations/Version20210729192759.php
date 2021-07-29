<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210729192759 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category_document ADD tribe_id INT NOT NULL');
        $this->addSql('ALTER TABLE category_document ADD CONSTRAINT FK_6F130E0D6F3EE0AD FOREIGN KEY (tribe_id) REFERENCES tribe (id)');
        $this->addSql('CREATE INDEX IDX_6F130E0D6F3EE0AD ON category_document (tribe_id)');
        $this->addSql('ALTER TABLE repertoire CHANGE ind_phone ind_phone VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category_document DROP FOREIGN KEY FK_6F130E0D6F3EE0AD');
        $this->addSql('DROP INDEX IDX_6F130E0D6F3EE0AD ON category_document');
        $this->addSql('ALTER TABLE category_document DROP tribe_id');
        $this->addSql('ALTER TABLE repertoire CHANGE ind_phone ind_phone INT DEFAULT NULL');
    }
}
