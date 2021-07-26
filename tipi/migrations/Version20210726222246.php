<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210726222246 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE documents DROP FOREIGN KEY FK_A2B07288C54C8C93');
        $this->addSql('CREATE TABLE category_document (id INT AUTO_INCREMENT NOT NULL, title_category_document VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE files');
        $this->addSql('DROP TABLE types');
        $this->addSql('DROP INDEX IDX_A2B07288C54C8C93 ON documents');
        $this->addSql('ALTER TABLE documents ADD title_category_document_id INT NOT NULL, ADD file_title VARCHAR(255) NOT NULL, DROP type_id, DROP file_id');
        $this->addSql('ALTER TABLE documents ADD CONSTRAINT FK_A2B07288AE32570C FOREIGN KEY (title_category_document_id) REFERENCES category_document (id)');
        $this->addSql('CREATE INDEX IDX_A2B07288AE32570C ON documents (title_category_document_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE documents DROP FOREIGN KEY FK_A2B07288AE32570C');
        $this->addSql('CREATE TABLE files (id INT AUTO_INCREMENT NOT NULL, document_id INT NOT NULL, title_file VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, file VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date DATETIME NOT NULL, INDEX IDX_6354059C33F7837 (document_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE types (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE files ADD CONSTRAINT FK_6354059C33F7837 FOREIGN KEY (document_id) REFERENCES documents (id)');
        $this->addSql('DROP TABLE category_document');
        $this->addSql('DROP INDEX IDX_A2B07288AE32570C ON documents');
        $this->addSql('ALTER TABLE documents ADD file_id INT NOT NULL, DROP file_title, CHANGE title_category_document_id type_id INT NOT NULL');
        $this->addSql('ALTER TABLE documents ADD CONSTRAINT FK_A2B07288C54C8C93 FOREIGN KEY (type_id) REFERENCES types (id)');
        $this->addSql('CREATE INDEX IDX_A2B07288C54C8C93 ON documents (type_id)');
    }
}
