<?php declare(strict_types = 1);

namespace Session\Infrastructure\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20180115204914 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql('CREATE TABLE users_followed (user_id CHAR(36) NOT NULL COMMENT \'(DC2Type:user_id)\', user_followed_id CHAR(36) NOT NULL COMMENT \'(DC2Type:user_id)\', INDEX IDX_364397CDA76ED395 (user_id), INDEX IDX_364397CD704D3985 (user_followed_id), PRIMARY KEY(user_id, user_followed_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE users_followed ADD CONSTRAINT FK_364397CDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE users_followed ADD CONSTRAINT FK_364397CD704D3985 FOREIGN KEY (user_followed_id) REFERENCES user (id)');
    }

    public function down(Schema $schema)
    {
        $this->addSql('DROP TABLE users_followed');
    }
}
