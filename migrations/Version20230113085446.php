<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230113085446 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE created_perfume DROP FOREIGN KEY FK_4DB9B20C126F525E');
        $this->addSql('ALTER TABLE reproduced_perfume DROP FOREIGN KEY FK_10745F28126F525E');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, image VARCHAR(255) NOT NULL, price VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_created_perfume (product_id INT NOT NULL, created_perfume_id INT NOT NULL, INDEX IDX_7F32B7914584665A (product_id), INDEX IDX_7F32B791B15FB0B (created_perfume_id), PRIMARY KEY(product_id, created_perfume_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_reproduced_perfume (product_id INT NOT NULL, reproduced_perfume_id INT NOT NULL, INDEX IDX_E2A2DA544584665A (product_id), INDEX IDX_E2A2DA543A5426C6 (reproduced_perfume_id), PRIMARY KEY(product_id, reproduced_perfume_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_created_perfume ADD CONSTRAINT FK_7F32B7914584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_created_perfume ADD CONSTRAINT FK_7F32B791B15FB0B FOREIGN KEY (created_perfume_id) REFERENCES created_perfume (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_reproduced_perfume ADD CONSTRAINT FK_E2A2DA544584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_reproduced_perfume ADD CONSTRAINT FK_E2A2DA543A5426C6 FOREIGN KEY (reproduced_perfume_id) REFERENCES reproduced_perfume (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE item');
        $this->addSql('DROP INDEX IDX_4DB9B20C126F525E ON created_perfume');
        $this->addSql('ALTER TABLE created_perfume DROP item_id, CHANGE sampling_validation sampling_validation TINYINT(1) DEFAULT 0 NOT NULL');
        $this->addSql('DROP INDEX IDX_10745F28126F525E ON reproduced_perfume');
        $this->addSql('ALTER TABLE reproduced_perfume DROP item_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE item (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, price VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, image VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE product_created_perfume DROP FOREIGN KEY FK_7F32B7914584665A');
        $this->addSql('ALTER TABLE product_created_perfume DROP FOREIGN KEY FK_7F32B791B15FB0B');
        $this->addSql('ALTER TABLE product_reproduced_perfume DROP FOREIGN KEY FK_E2A2DA544584665A');
        $this->addSql('ALTER TABLE product_reproduced_perfume DROP FOREIGN KEY FK_E2A2DA543A5426C6');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_created_perfume');
        $this->addSql('DROP TABLE product_reproduced_perfume');
        $this->addSql('ALTER TABLE created_perfume ADD item_id INT NOT NULL, CHANGE sampling_validation sampling_validation TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE created_perfume ADD CONSTRAINT FK_4DB9B20C126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
        $this->addSql('CREATE INDEX IDX_4DB9B20C126F525E ON created_perfume (item_id)');
        $this->addSql('ALTER TABLE reproduced_perfume ADD item_id INT NOT NULL');
        $this->addSql('ALTER TABLE reproduced_perfume ADD CONSTRAINT FK_10745F28126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
        $this->addSql('CREATE INDEX IDX_10745F28126F525E ON reproduced_perfume (item_id)');
    }
}
