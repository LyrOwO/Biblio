<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250408074601 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        #$this->addSql('DROP INDEX UNIQ_CBE5A331CC1CF4E6 ON book');
        #$this->addSql('ALTER TABLE book DROP isbn');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CBE5A3318BB0FF4B ON book (industry_identifiers_identifier)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        #$this->addSql('DROP INDEX UNIQ_CBE5A3318BB0FF4B ON book');
        #$this->addSql('ALTER TABLE book ADD isbn VARCHAR(13) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CBE5A331CC1CF4E6 ON book (isbn)');
    }
}
