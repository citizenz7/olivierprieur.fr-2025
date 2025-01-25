<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250123092814 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE portfolio (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, techno VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', image VARCHAR(255) NOT NULL, presentation LONGTEXT NOT NULL, url VARCHAR(255) DEFAULT NULL, filter VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE portfolio_category (portfolio_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_7AC64359B96B5643 (portfolio_id), INDEX IDX_7AC6435912469DE2 (category_id), PRIMARY KEY(portfolio_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE portfolio_category ADD CONSTRAINT FK_7AC64359B96B5643 FOREIGN KEY (portfolio_id) REFERENCES portfolio (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE portfolio_category ADD CONSTRAINT FK_7AC6435912469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE portfolio_category DROP FOREIGN KEY FK_7AC64359B96B5643');
        $this->addSql('ALTER TABLE portfolio_category DROP FOREIGN KEY FK_7AC6435912469DE2');
        $this->addSql('DROP TABLE portfolio');
        $this->addSql('DROP TABLE portfolio_category');
    }
}
