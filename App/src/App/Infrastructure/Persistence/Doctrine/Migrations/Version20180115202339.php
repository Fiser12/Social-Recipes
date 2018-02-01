<?php declare(strict_types = 1);

namespace App\Infrastructure\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20180115202339 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql('ALTER TABLE user ADD facebook_id_id VARCHAR(255) NOT NULL, ADD facebook_access_token_token VARCHAR(255) NOT NULL, ADD facebook_access_token_createdOn DATE NOT NULL');
    }

    public function down(Schema $schema)
    {
        $this->addSql('ALTER TABLE user DROP facebook_id_id, DROP facebook_access_token_token, DROP facebook_access_token_createdOn');
    }
}
