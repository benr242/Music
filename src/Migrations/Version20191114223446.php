<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191114223446 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE song (id INT AUTO_INCREMENT NOT NULL, album_id INT NOT NULL, name VARCHAR(255) NOT NULL, length INT NOT NULL, number INT NOT NULL, UNIQUE INDEX UNIQ_33EDEEA196901F54 (number), INDEX IDX_33EDEEA11137ABCF (album_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE album (id INT AUTO_INCREMENT NOT NULL, artist_id INT NOT NULL, name VARCHAR(255) NOT NULL, year INT NOT NULL, INDEX IDX_39986E43B7970CF8 (artist_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE artist (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(8) NOT NULL, logo VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_15996875E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE person (id INT AUTO_INCREMENT NOT NULL, first VARCHAR(255) NOT NULL, middle VARCHAR(255) DEFAULT NULL, last VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE song ADD CONSTRAINT FK_33EDEEA11137ABCF FOREIGN KEY (album_id) REFERENCES album (id)');
        $this->addSql('ALTER TABLE album ADD CONSTRAINT FK_39986E43B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE song DROP FOREIGN KEY FK_33EDEEA11137ABCF');
        $this->addSql('ALTER TABLE album DROP FOREIGN KEY FK_39986E43B7970CF8');
        $this->addSql('DROP TABLE song');
        $this->addSql('DROP TABLE album');
        $this->addSql('DROP TABLE artist');
        $this->addSql('DROP TABLE person');
    }
}
