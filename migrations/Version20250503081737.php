<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250503081737 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE conquete_caracteres DROP FOREIGN KEY FK_E6B351E19C5E969
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE conquete_caracteres DROP FOREIGN KEY FK_E6B351E14779418
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE conquete_caracteres
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE conquete ADD name VARCHAR(100) NOT NULL, ADD gender VARCHAR(10) NOT NULL, DROP nom, DROP prenom, DROP image, CHANGE breed breed VARCHAR(255) NOT NULL, CHANGE age image_id INT NOT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE conquete_caracteres (conquete_id INT NOT NULL, caractere_id INT NOT NULL, INDEX IDX_E6B351E14779418 (caractere_id), INDEX IDX_E6B351E19C5E969 (conquete_id), PRIMARY KEY(conquete_id, caractere_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE conquete_caracteres ADD CONSTRAINT FK_E6B351E19C5E969 FOREIGN KEY (conquete_id) REFERENCES conquete (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE conquete_caracteres ADD CONSTRAINT FK_E6B351E14779418 FOREIGN KEY (caractere_id) REFERENCES caractere (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE conquete ADD prenom VARCHAR(100) NOT NULL, ADD image VARCHAR(255) NOT NULL, DROP gender, CHANGE breed breed VARCHAR(255) DEFAULT NULL, CHANGE name nom VARCHAR(100) NOT NULL, CHANGE image_id age INT NOT NULL
        SQL);
    }
}
