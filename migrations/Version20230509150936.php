<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230509150936 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->getTable('event');
        $table->addIndex(['name', 'created_at']);
    }

    public function down(Schema $schema): void
    {
        $table = $schema->getTable('event');
        $table->dropIndex('event_name_created_at_idx');
    }
}
