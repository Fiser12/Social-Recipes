<?php declare(strict_types = 1);

namespace Session\Infrastructure\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20180115192749 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql('CREATE TABLE user (id CHAR(36) NOT NULL COMMENT \'(DC2Type:user_id)\', created_on DATETIME NOT NULL, last_login DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:user_roles)\', updated_on DATETIME NOT NULL, confirmationToken_token VARCHAR(36) DEFAULT NULL, confirmationToken_created_on DATETIME DEFAULT NULL, email VARCHAR(60) NOT NULL, invitationToken_token VARCHAR(36) DEFAULT NULL, invitationToken_created_on DATETIME DEFAULT NULL, password VARCHAR(60) DEFAULT NULL, salt VARCHAR(60) DEFAULT NULL, rememberPasswordToken_token VARCHAR(36) DEFAULT NULL, rememberPasswordToken_created_on DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema)
    {
        $this->addSql('DROP TABLE user');
    }
}
