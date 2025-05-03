<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250503062141 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE conquete (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) NOT NULL, age INT NOT NULL, breed VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE conquete_caracteres (conquete_id INT NOT NULL, caractere_id INT NOT NULL, INDEX IDX_E6B351E19C5E969 (conquete_id), INDEX IDX_E6B351E14779418 (caractere_id), PRIMARY KEY(conquete_id, caractere_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE conquete_caracteres ADD CONSTRAINT FK_E6B351E19C5E969 FOREIGN KEY (conquete_id) REFERENCES conquete (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE conquete_caracteres ADD CONSTRAINT FK_E6B351E14779418 FOREIGN KEY (caractere_id) REFERENCES caractere (id) ON DELETE CASCADE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE conquete_caracteres DROP FOREIGN KEY FK_E6B351E19C5E969
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE conquete_caracteres DROP FOREIGN KEY FK_E6B351E14779418
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE conquete
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE conquete_caracteres
        SQL);
    }
}
