<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230201234611 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE purchased_product ADD product_id INT NOT NULL');
        $this->addSql('ALTER TABLE purchased_product ADD CONSTRAINT FK_22A4A88D4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_22A4A88D4584665A ON purchased_product (product_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE purchased_product DROP FOREIGN KEY FK_22A4A88D4584665A');
        $this->addSql('DROP INDEX IDX_22A4A88D4584665A ON purchased_product');
        $this->addSql('ALTER TABLE purchased_product DROP product_id');
    }
}
