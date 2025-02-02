<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231108092228 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add announceUserCount field to ConferenceRooms table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ConferenceRooms ADD announceUserCount VARCHAR(10) DEFAULT \'first\' NOT NULL COMMENT \'[enum:always|first]\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ConferenceRooms DROP announceUserCount');
    }
}
