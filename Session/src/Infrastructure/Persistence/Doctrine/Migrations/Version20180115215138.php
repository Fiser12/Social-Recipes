<?php declare(strict_types = 1);

namespace Session\Infrastructure\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180115215138 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD full_name_first_name_firstName VARCHAR(255) NOT NULL, ADD full_name_last_name_lastName VARCHAR(255) NOT NULL, DROP facebook_access_token_createdOn');
        $this->addSql('ALTER TABLE users_followed DROP FOREIGN KEY FK_364397CD704D3985');
        $this->addSql('ALTER TABLE users_followed DROP FOREIGN KEY FK_364397CDA76ED395');
        $this->addSql('ALTER TABLE users_followed ADD CONSTRAINT FK_364397CD704D3985 FOREIGN KEY (user_followed_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_followed ADD CONSTRAINT FK_364397CDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD facebook_access_token_createdOn DATE NOT NULL, DROP full_name_first_name_firstName, DROP full_name_last_name_lastName');
        $this->addSql('ALTER TABLE users_followed DROP FOREIGN KEY FK_364397CDA76ED395');
        $this->addSql('ALTER TABLE users_followed DROP FOREIGN KEY FK_364397CD704D3985');
        $this->addSql('ALTER TABLE users_followed ADD CONSTRAINT FK_364397CDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE users_followed ADD CONSTRAINT FK_364397CD704D3985 FOREIGN KEY (user_followed_id) REFERENCES user (id)');
    }
}
