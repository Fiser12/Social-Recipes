<?php

/*
 * This file is part of the Social Recipes project.
 *
 * Copyright (c) 2017 LIN3S <ruben@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170924223240 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE users_followed (user_id CHAR(36) NOT NULL COMMENT \'(DC2Type:user_id)\', user_followed_id CHAR(36) NOT NULL COMMENT \'(DC2Type:user_id)\', INDEX IDX_364397CDA76ED395 (user_id), INDEX IDX_364397CD704D3985 (user_followed_id), PRIMARY KEY(user_id, user_followed_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE users_followed ADD CONSTRAINT FK_364397CDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE users_followed ADD CONSTRAINT FK_364397CD704D3985 FOREIGN KEY (user_followed_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD facebookId_id VARCHAR(255) NOT NULL, ADD facebookAccessToken_token VARCHAR(255) NOT NULL, DROP facebook_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE users_followed');
        $this->addSql('ALTER TABLE user ADD facebook_id CHAR(36) DEFAULT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:guid)\', DROP facebookId_id, DROP facebookAccessToken_token');
    }
}
