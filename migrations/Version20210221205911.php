<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210221205911 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY commande_ibfk_1');
        $this->addSql('ALTER TABLE beachstation DROP FOREIGN KEY beachstation_ibfk_1');
        $this->addSql('ALTER TABLE beachwaterquality DROP FOREIGN KEY beachwaterquality_ibfk_1');
        $this->addSql('ALTER TABLE swimadvisories DROP FOREIGN KEY swimadvisories_ibfk_1');
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, content LONGTEXT DEFAULT NULL, picture VARCHAR(255) DEFAULT NULL, is_published TINYINT(1) NOT NULL, published_at DATETIME DEFAULT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE air_pollution');
        $this->addSql('DROP TABLE beachstation');
        $this->addSql('DROP TABLE beachwaterquality');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE departement');
        $this->addSql('DROP TABLE employe');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE sensorlocation');
        $this->addSql('DROP TABLE stock');
        $this->addSql('DROP TABLE swimadvisories');
        $this->addSql('DROP TABLE user');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE air_pollution (id VARCHAR(42) NOT NULL COLLATE utf8_general_ci, timestamp VARCHAR(42) DEFAULT NULL COLLATE utf8_general_ci, `float` VARCHAR(42) DEFAULT NULL COLLATE utf8_general_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE beachstation (measurement_id VARCHAR(42) NOT NULL COLLATE utf8_general_ci, sha1 VARCHAR(42) DEFAULT NULL COLLATE utf8_general_ci, measurement_timestamp VARCHAR(42) DEFAULT NULL COLLATE utf8_general_ci, air_temperature VARCHAR(42) DEFAULT NULL COLLATE utf8_general_ci, rain_intensity VARCHAR(42) DEFAULT NULL COLLATE utf8_general_ci, precipitation_type VARCHAR(42) DEFAULT NULL COLLATE utf8_general_ci, wind_direction VARCHAR(42) DEFAULT NULL COLLATE utf8_general_ci, maximum_wind_speed VARCHAR(42) DEFAULT NULL COLLATE utf8_general_ci, solar_radiation VARCHAR(42) DEFAULT NULL COLLATE utf8_general_ci, INDEX sha1 (sha1), PRIMARY KEY(measurement_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE beachwaterquality (measurement_id VARCHAR(42) NOT NULL COLLATE utf8_general_ci, sha1 VARCHAR(42) DEFAULT NULL COLLATE utf8_general_ci, measurement_timestamp VARCHAR(42) DEFAULT NULL COLLATE utf8_general_ci, water_temperature VARCHAR(42) DEFAULT NULL COLLATE utf8_general_ci, turbidity VARCHAR(42) DEFAULT NULL COLLATE utf8_general_ci, wave_height VARCHAR(42) DEFAULT NULL COLLATE utf8_general_ci, wave_period VARCHAR(42) DEFAULT NULL COLLATE utf8_general_ci, INDEX sha1 (sha1), PRIMARY KEY(measurement_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE category (category_id INT AUTO_INCREMENT NOT NULL, name VARCHAR(45) NOT NULL COLLATE utf8_unicode_ci, PRIMARY KEY(category_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE commande (id_commande INT AUTO_INCREMENT NOT NULL, id_produit INT NOT NULL, date_commande DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, date_livraison DATETIME DEFAULT NULL, quantite INT NOT NULL, INDEX id_produit (id_produit), PRIMARY KEY(id_commande)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE departement (iddept INT NOT NULL, name VARCHAR(20) NOT NULL COLLATE utf8_general_ci, PRIMARY KEY(iddept)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('CREATE TABLE employe (id INT UNSIGNED NOT NULL, login VARCHAR(50) NOT NULL COLLATE utf8_general_ci, password VARCHAR(50) NOT NULL COLLATE utf8_general_ci, prenom VARCHAR(50) NOT NULL COLLATE utf8_general_ci, nom VARCHAR(50) NOT NULL COLLATE utf8_general_ci, email VARCHAR(50) DEFAULT NULL COLLATE utf8_general_ci, role VARCHAR(20) NOT NULL COLLATE utf8_general_ci, id_dept INT DEFAULT NULL, INDEX fk_iddept (id_dept), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('CREATE TABLE product (product_id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, name INT NOT NULL, price DOUBLE PRECISION NOT NULL, INDEX category (category_id), PRIMARY KEY(product_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE produit (id_produit INT AUTO_INCREMENT NOT NULL, produit VARCHAR(50) NOT NULL COLLATE utf8_general_ci, prix_hors_taxe DOUBLE PRECISION NOT NULL, tva DOUBLE PRECISION NOT NULL, fournisseur VARCHAR(50) NOT NULL COLLATE utf8_general_ci, PRIMARY KEY(id_produit)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE sensorlocation (sha1 VARCHAR(42) NOT NULL COLLATE utf8_general_ci, sensor_name VARCHAR(42) DEFAULT NULL COLLATE utf8_general_ci, sensor_type VARCHAR(42) DEFAULT NULL COLLATE utf8_general_ci, latitude VARCHAR(42) DEFAULT NULL COLLATE utf8_general_ci, longitude VARCHAR(42) DEFAULT NULL COLLATE utf8_general_ci, PRIMARY KEY(sha1)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE stock (STOCK_ID INT UNSIGNED AUTO_INCREMENT NOT NULL, STOCK_CODE VARCHAR(10) NOT NULL COLLATE utf8_general_ci, STOCK_NAME VARCHAR(20) NOT NULL COLLATE utf8_general_ci, UNIQUE INDEX UNI_STOCK_ID (STOCK_CODE), UNIQUE INDEX UNI_STOCK_NAME (STOCK_NAME), PRIMARY KEY(STOCK_ID)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE swimadvisories (record_id VARCHAR(42) NOT NULL COLLATE utf8_general_ci, sha1 VARCHAR(42) DEFAULT NULL COLLATE utf8_general_ci, date VARCHAR(42) DEFAULT NULL COLLATE utf8_general_ci, predicted_level VARCHAR(42) DEFAULT NULL COLLATE utf8_general_ci, probability VARCHAR(42) DEFAULT NULL COLLATE utf8_general_ci, advisory VARCHAR(42) DEFAULT NULL COLLATE utf8_general_ci, INDEX sha1 (sha1), PRIMARY KEY(record_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE user (user_id INT AUTO_INCREMENT NOT NULL, email VARCHAR(45) NOT NULL COLLATE utf8_unicode_ci, password VARCHAR(10) NOT NULL COLLATE utf8_unicode_ci, PRIMARY KEY(user_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE beachstation ADD CONSTRAINT beachstation_ibfk_1 FOREIGN KEY (sha1) REFERENCES sensorlocation (sha1)');
        $this->addSql('ALTER TABLE beachwaterquality ADD CONSTRAINT beachwaterquality_ibfk_1 FOREIGN KEY (sha1) REFERENCES sensorlocation (sha1)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT commande_ibfk_1 FOREIGN KEY (id_produit) REFERENCES produit (id_produit) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE swimadvisories ADD CONSTRAINT swimadvisories_ibfk_1 FOREIGN KEY (sha1) REFERENCES sensorlocation (sha1)');
        $this->addSql('DROP TABLE article');
    }
}
