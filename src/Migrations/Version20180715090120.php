<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180715090120 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE animal (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, area_id INT DEFAULT NULL, city_id INT DEFAULT NULL, animals_id INT DEFAULT NULL, risk_id INT DEFAULT NULL, payment_method_id INT DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) DEFAULT NULL, telephone_number VARCHAR(255) DEFAULT NULL, shipping_method VARCHAR(255) DEFAULT NULL, comments VARCHAR(8000) DEFAULT NULL, INDEX IDX_81398E09BD0F409C (area_id), INDEX IDX_81398E098BAC62AF (city_id), INDEX IDX_81398E09132B9E58 (animals_id), INDEX IDX_81398E09235B6D1 (risk_id), INDEX IDX_81398E095AA1164F (payment_method_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer_area (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer_city (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer_payment (id INT AUTO_INCREMENT NOT NULL, payment_type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer_risk (id INT AUTO_INCREMENT NOT NULL, risk VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, name VARCHAR(255) NOT NULL, artifact_number INT NOT NULL, catalogue_page INT DEFAULT NULL, quantity VARCHAR(255) DEFAULT NULL, cost DOUBLE PRECISION NOT NULL, comments VARCHAR(8000) DEFAULT NULL, stock INT NOT NULL, INDEX IDX_D34A04AD12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09BD0F409C FOREIGN KEY (area_id) REFERENCES customer_area (id)');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E098BAC62AF FOREIGN KEY (city_id) REFERENCES customer_city (id)');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09132B9E58 FOREIGN KEY (animals_id) REFERENCES animal (id)');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09235B6D1 FOREIGN KEY (risk_id) REFERENCES customer_risk (id)');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E095AA1164F FOREIGN KEY (payment_method_id) REFERENCES customer_payment (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES product_category (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E09132B9E58');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E09BD0F409C');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E098BAC62AF');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E095AA1164F');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E09235B6D1');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('DROP TABLE animal');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE customer_area');
        $this->addSql('DROP TABLE customer_city');
        $this->addSql('DROP TABLE customer_payment');
        $this->addSql('DROP TABLE customer_risk');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_category');
    }
}
