<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180823211031 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE product_order_item (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, product_order_id INT NOT NULL, product_quantity INT NOT NULL, cost DOUBLE PRECISION NOT NULL, INDEX IDX_C18D40224584665A (product_id), INDEX IDX_C18D4022462F07AF (product_order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_order_item ADD CONSTRAINT FK_C18D40224584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product_order_item ADD CONSTRAINT FK_C18D4022462F07AF FOREIGN KEY (product_order_id) REFERENCES product_order (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_order DROP FOREIGN KEY FK_5475E8C44584665A');
        $this->addSql('DROP INDEX IDX_5475E8C44584665A ON product_order');
        $this->addSql('ALTER TABLE product_order DROP product_id, DROP product_order_quantity, DROP cost');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE product_order_item');
        $this->addSql('ALTER TABLE product_order ADD product_id INT NOT NULL, ADD product_order_quantity INT NOT NULL, ADD cost DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE product_order ADD CONSTRAINT FK_5475E8C44584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_5475E8C44584665A ON product_order (product_id)');
    }
}
