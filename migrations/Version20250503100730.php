<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250503100730 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE cats_conquetes (cats_id INT NOT NULL, conquete_id INT NOT NULL, INDEX IDX_3297729E84200A6 (cats_id), INDEX IDX_3297729E9C5E969 (conquete_id), PRIMARY KEY(cats_id, conquete_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cats_conquetes ADD CONSTRAINT FK_3297729E84200A6 FOREIGN KEY (cats_id) REFERENCES cats (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cats_conquetes ADD CONSTRAINT FK_3297729E9C5E969 FOREIGN KEY (conquete_id) REFERENCES conquete (id) ON DELETE CASCADE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE cats_conquetes DROP FOREIGN KEY FK_3297729E84200A6
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cats_conquetes DROP FOREIGN KEY FK_3297729E9C5E969
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE cats_conquetes
        SQL);
    }
}
