<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220612082353 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adresses (id INT AUTO_INCREMENT NOT NULL, street VARCHAR(255) NOT NULL, city VARCHAR(200) NOT NULL, postal_code INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bills_content (id INT AUTO_INCREMENT NOT NULL, id_bill_skeleton_id INT NOT NULL, bill_number INT NOT NULL, designation VARCHAR(255) NOT NULL, quantity INT NOT NULL, price NUMERIC(7, 2) NOT NULL, INDEX IDX_63B46EA236C3B641 (id_bill_skeleton_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bills_skeleton (id INT AUTO_INCREMENT NOT NULL, date_edition DATE NOT NULL, siret_number INT NOT NULL, client_number INT NOT NULL, title VARCHAR(255) NOT NULL, transmitter VARCHAR(255) NOT NULL, name_lodging VARCHAR(255) NOT NULL, name_client VARCHAR(255) NOT NULL, date_erasing DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bookings (id INT AUTO_INCREMENT NOT NULL, id_lodging_id INT NOT NULL, client_id INT NOT NULL, nb_adults INT NOT NULL, nb_children INT NOT NULL, date_departure DATE NOT NULL, date_arrival DATE NOT NULL, INDEX IDX_7A853C3522B9DA26 (id_lodging_id), INDEX IDX_7A853C3519EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, addresse_id INT NOT NULL, first_name VARCHAR(150) NOT NULL, last_name VARCHAR(150) NOT NULL, UNIQUE INDEX UNIQ_C7440455B299877A (addresse_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE extra_type (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, price NUMERIC(5, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE extras (id INT AUTO_INCREMENT NOT NULL, extra_type_id INT NOT NULL, booking_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_269B65D11D978B71 (extra_type_id), INDEX IDX_269B65D13301C60 (booking_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lodging (id INT AUTO_INCREMENT NOT NULL, id_typelodging_id INT NOT NULL, id_user_id INT NOT NULL, name VARCHAR(150) NOT NULL, filename VARCHAR(255) NOT NULL, update_at DATE NOT NULL, INDEX IDX_8D35182A430F07FA (id_typelodging_id), INDEX IDX_8D35182A79F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE taxes_percentage (id INT AUTO_INCREMENT NOT NULL, type_taxes VARCHAR(150) NOT NULL, percent NUMERIC(5, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_lodging (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(150) NOT NULL, places INT NOT NULL, price NUMERIC(5, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, id_adresses_id INT NOT NULL, type_user VARCHAR(50) NOT NULL, mail VARCHAR(255) NOT NULL, first_name VARCHAR(150) NOT NULL, password VARCHAR(255) NOT NULL, last_name VARCHAR(150) NOT NULL, UNIQUE INDEX UNIQ_8D93D6499DF38AD1 (id_adresses_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bills_content ADD CONSTRAINT FK_63B46EA236C3B641 FOREIGN KEY (id_bill_skeleton_id) REFERENCES bills_skeleton (id)');
        $this->addSql('ALTER TABLE bookings ADD CONSTRAINT FK_7A853C3522B9DA26 FOREIGN KEY (id_lodging_id) REFERENCES lodging (id)');
        $this->addSql('ALTER TABLE bookings ADD CONSTRAINT FK_7A853C3519EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455B299877A FOREIGN KEY (addresse_id) REFERENCES adresses (id)');
        $this->addSql('ALTER TABLE extras ADD CONSTRAINT FK_269B65D11D978B71 FOREIGN KEY (extra_type_id) REFERENCES extra_type (id)');
        $this->addSql('ALTER TABLE extras ADD CONSTRAINT FK_269B65D13301C60 FOREIGN KEY (booking_id) REFERENCES bookings (id)');
        $this->addSql('ALTER TABLE lodging ADD CONSTRAINT FK_8D35182A430F07FA FOREIGN KEY (id_typelodging_id) REFERENCES type_lodging (id)');
        $this->addSql('ALTER TABLE lodging ADD CONSTRAINT FK_8D35182A79F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6499DF38AD1 FOREIGN KEY (id_adresses_id) REFERENCES adresses (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455B299877A');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6499DF38AD1');
        $this->addSql('ALTER TABLE bills_content DROP FOREIGN KEY FK_63B46EA236C3B641');
        $this->addSql('ALTER TABLE extras DROP FOREIGN KEY FK_269B65D13301C60');
        $this->addSql('ALTER TABLE bookings DROP FOREIGN KEY FK_7A853C3519EB6921');
        $this->addSql('ALTER TABLE extras DROP FOREIGN KEY FK_269B65D11D978B71');
        $this->addSql('ALTER TABLE bookings DROP FOREIGN KEY FK_7A853C3522B9DA26');
        $this->addSql('ALTER TABLE lodging DROP FOREIGN KEY FK_8D35182A430F07FA');
        $this->addSql('ALTER TABLE lodging DROP FOREIGN KEY FK_8D35182A79F37AE5');
        $this->addSql('DROP TABLE adresses');
        $this->addSql('DROP TABLE bills_content');
        $this->addSql('DROP TABLE bills_skeleton');
        $this->addSql('DROP TABLE bookings');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE extra_type');
        $this->addSql('DROP TABLE extras');
        $this->addSql('DROP TABLE lodging');
        $this->addSql('DROP TABLE taxes_percentage');
        $this->addSql('DROP TABLE type_lodging');
        $this->addSql('DROP TABLE user');
    }
}
