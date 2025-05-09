<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250509121609 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE shelve_book (shelve_id INT NOT NULL, book_id INT NOT NULL, INDEX IDX_D8A4EF4A69FBF2AF (shelve_id), INDEX IDX_D8A4EF4A16A2B381 (book_id), PRIMARY KEY(shelve_id, book_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE shelve_book ADD CONSTRAINT FK_D8A4EF4A69FBF2AF FOREIGN KEY (shelve_id) REFERENCES shelve (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shelve_book ADD CONSTRAINT FK_D8A4EF4A16A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE book CHANGE added_by_id added_by_id INT NOT NULL');
        $this->addSql('ALTER TABLE shelve ADD owner_id INT NOT NULL');
        $this->addSql('ALTER TABLE shelve ADD CONSTRAINT FK_9CBE9C927E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_9CBE9C927E3C61F9 ON shelve (owner_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE shelve_book DROP FOREIGN KEY FK_D8A4EF4A69FBF2AF');
        $this->addSql('ALTER TABLE shelve_book DROP FOREIGN KEY FK_D8A4EF4A16A2B381');
        $this->addSql('DROP TABLE shelve_book');
        $this->addSql('ALTER TABLE book CHANGE added_by_id added_by_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE shelve DROP FOREIGN KEY FK_9CBE9C927E3C61F9');
        $this->addSql('DROP INDEX IDX_9CBE9C927E3C61F9 ON shelve');
        $this->addSql('ALTER TABLE shelve DROP owner_id');
    }
}
