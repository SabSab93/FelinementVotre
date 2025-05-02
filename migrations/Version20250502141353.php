<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250502141353 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE caractere (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE cats_caractere (cats_id INT NOT NULL, caractere_id INT NOT NULL, INDEX IDX_6F033ED584200A6 (cats_id), INDEX IDX_6F033ED54779418 (caractere_id), PRIMARY KEY(cats_id, caractere_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cats_caractere ADD CONSTRAINT FK_6F033ED584200A6 FOREIGN KEY (cats_id) REFERENCES cats (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cats_caractere ADD CONSTRAINT FK_6F033ED54779418 FOREIGN KEY (caractere_id) REFERENCES caractere (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cats ADD description LONGTEXT DEFAULT NULL, ADD image_id INT DEFAULT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE cats_caractere DROP FOREIGN KEY FK_6F033ED584200A6
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cats_caractere DROP FOREIGN KEY FK_6F033ED54779418
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE caractere
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE cats_caractere
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cats DROP description, DROP image_id
        SQL);
    }
}
