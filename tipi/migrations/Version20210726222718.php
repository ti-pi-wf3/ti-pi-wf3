<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210726222718 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category_document (id INT AUTO_INCREMENT NOT NULL, title_category_document VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE documents (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, title_category_document_id INT NOT NULL, date DATETIME NOT NULL, file_title VARCHAR(255) NOT NULL, title_document VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_A2B07288A76ED395 (user_id), INDEX IDX_A2B07288AE32570C (title_category_document_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE files (id INT AUTO_INCREMENT NOT NULL, document_id INT NOT NULL, title_file VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, file_upload VARCHAR(255) NOT NULL, date DATETIME NOT NULL, INDEX IDX_6354059C33F7837 (document_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE documents ADD CONSTRAINT FK_A2B07288A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE documents ADD CONSTRAINT FK_A2B07288AE32570C FOREIGN KEY (title_category_document_id) REFERENCES category_document (id)');
        $this->addSql('ALTER TABLE files ADD CONSTRAINT FK_6354059C33F7837 FOREIGN KEY (document_id) REFERENCES documents (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE documents DROP FOREIGN KEY FK_A2B07288AE32570C');
        $this->addSql('ALTER TABLE files DROP FOREIGN KEY FK_6354059C33F7837');
        $this->addSql('DROP TABLE category_document');
        $this->addSql('DROP TABLE documents');
        $this->addSql('DROP TABLE files');
    }
}
