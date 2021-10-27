<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210721122002 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tribe (id INT AUTO_INCREMENT NOT NULL, tribe_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, tribe_id_id INT NOT NULL, role LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', sexe VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, maiden_name VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, birth_date DATE NOT NULL, phone INT DEFAULT NULL, ind_phone VARCHAR(255) DEFAULT NULL, INDEX IDX_8D93D64928FEE52B (tribe_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64928FEE52B FOREIGN KEY (tribe_id_id) REFERENCES tribe (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64928FEE52B');
        $this->addSql('DROP TABLE tribe');
        $this->addSql('DROP TABLE user');
    }
}
