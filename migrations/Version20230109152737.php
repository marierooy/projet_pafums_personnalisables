<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230109152737 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE base_scent (id INT AUTO_INCREMENT NOT NULL, scent VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE created_perfume (id INT AUTO_INCREMENT NOT NULL, head_scent_id INT NOT NULL, heart_scent_id INT NOT NULL, base_scent_id INT NOT NULL, item_id INT NOT NULL, proportion_head_scent VARCHAR(255) NOT NULL, proportion_heart_scent VARCHAR(255) NOT NULL, proportion_base_scent VARCHAR(255) NOT NULL, sampling_price VARCHAR(255) NOT NULL, sampling_validation TINYINT(1) NOT NULL, INDEX IDX_4DB9B20C942F8BDB (head_scent_id), INDEX IDX_4DB9B20CA1F45DA2 (heart_scent_id), INDEX IDX_4DB9B20CB42EC0B6 (base_scent_id), INDEX IDX_4DB9B20C126F525E (item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE head_scent (id INT AUTO_INCREMENT NOT NULL, scent VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE heart_scent (id INT AUTO_INCREMENT NOT NULL, scent VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reproduced_perfume (id INT AUTO_INCREMENT NOT NULL, item_id INT NOT NULL, sampling_price VARCHAR(255) NOT NULL, INDEX IDX_10745F28126F525E (item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, zip_code VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, token VARCHAR(255) DEFAULT NULL, active TINYINT(1) DEFAULT 0 NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D6495F37A13B (token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE created_perfume ADD CONSTRAINT FK_4DB9B20C942F8BDB FOREIGN KEY (head_scent_id) REFERENCES head_scent (id)');
        $this->addSql('ALTER TABLE created_perfume ADD CONSTRAINT FK_4DB9B20CA1F45DA2 FOREIGN KEY (heart_scent_id) REFERENCES heart_scent (id)');
        $this->addSql('ALTER TABLE created_perfume ADD CONSTRAINT FK_4DB9B20CB42EC0B6 FOREIGN KEY (base_scent_id) REFERENCES base_scent (id)');
        $this->addSql('ALTER TABLE created_perfume ADD CONSTRAINT FK_4DB9B20C126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
        $this->addSql('ALTER TABLE reproduced_perfume ADD CONSTRAINT FK_10745F28126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE created_perfume DROP FOREIGN KEY FK_4DB9B20C942F8BDB');
        $this->addSql('ALTER TABLE created_perfume DROP FOREIGN KEY FK_4DB9B20CA1F45DA2');
        $this->addSql('ALTER TABLE created_perfume DROP FOREIGN KEY FK_4DB9B20CB42EC0B6');
        $this->addSql('ALTER TABLE created_perfume DROP FOREIGN KEY FK_4DB9B20C126F525E');
        $this->addSql('ALTER TABLE reproduced_perfume DROP FOREIGN KEY FK_10745F28126F525E');
        $this->addSql('DROP TABLE base_scent');
        $this->addSql('DROP TABLE created_perfume');
        $this->addSql('DROP TABLE head_scent');
        $this->addSql('DROP TABLE heart_scent');
        $this->addSql('DROP TABLE item');
        $this->addSql('DROP TABLE reproduced_perfume');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
