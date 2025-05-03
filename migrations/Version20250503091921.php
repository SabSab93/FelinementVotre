<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250503091921 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE conquete_caractere (conquete_id INT NOT NULL, caractere_id INT NOT NULL, INDEX IDX_DF67901A9C5E969 (conquete_id), INDEX IDX_DF67901A4779418 (caractere_id), PRIMARY KEY(conquete_id, caractere_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE conquete_caractere ADD CONSTRAINT FK_DF67901A9C5E969 FOREIGN KEY (conquete_id) REFERENCES conquete (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE conquete_caractere ADD CONSTRAINT FK_DF67901A4779418 FOREIGN KEY (caractere_id) REFERENCES caractere (id) ON DELETE CASCADE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE conquete_caractere DROP FOREIGN KEY FK_DF67901A9C5E969
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE conquete_caractere DROP FOREIGN KEY FK_DF67901A4779418
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE conquete_caractere
        SQL);
    }
}
