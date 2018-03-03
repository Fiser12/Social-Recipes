<?php declare(strict_types = 1);

namespace Recipes\Infrastructure\Persistence\Sql\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180302005001 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE recipe_category (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', parent_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', INDEX IDX_70DCBC5F727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe_book_translation (origin_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', locale VARCHAR(255) NOT NULL, title_title VARCHAR(255) NOT NULL, subtitle_subtitle VARCHAR(255) NOT NULL, PRIMARY KEY(locale, origin_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe_recipe_translation (origin_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', locale VARCHAR(255) NOT NULL, title_title VARCHAR(255) NOT NULL, subtitle_subtitle VARCHAR(255) NOT NULL, description_description VARCHAR(255) NOT NULL, PRIMARY KEY(locale, origin_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe_user (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', email_email VARCHAR(255) NOT NULL, email_localPart VARCHAR(255) NOT NULL, email_domain VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe_step (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', recipe_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', ingredients JSON NOT NULL COMMENT \'(DC2Type:json_object)\', tools JSON NOT NULL COMMENT \'(DC2Type:json_object)\', INDEX IDX_3CA2A4E359D8A214 (recipe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe_recipe (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', ingredients JSON NOT NULL COMMENT \'(DC2Type:json_object)\', tools JSON NOT NULL COMMENT \'(DC2Type:json_object)\', hashtags JSON NOT NULL COMMENT \'(DC2Type:json_object)\', owner_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', scope_scope VARCHAR(255) NOT NULL, servings_servings INT NOT NULL, time_seconds INT NOT NULL, difficulty_difficulty VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe_category_translation (origin_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', locale VARCHAR(255) NOT NULL, name_name VARCHAR(255) NOT NULL, PRIMARY KEY(locale, origin_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe_book (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', owner_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', scope_scope VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe_step_translation (origin_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', locale VARCHAR(255) NOT NULL, description_description VARCHAR(255) NOT NULL, PRIMARY KEY(locale, origin_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE recipe_category ADD CONSTRAINT FK_70DCBC5F727ACA70 FOREIGN KEY (parent_id) REFERENCES recipe_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_step ADD CONSTRAINT FK_3CA2A4E359D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe_step (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_step_translation ADD CONSTRAINT FK_3726HFLEJF3KJKEF FOREIGN KEY (origin_id) REFERENCES recipe_step (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_recipe_translation ADD CONSTRAINT FK_1726HFL4323KJKEF FOREIGN KEY (origin_id) REFERENCES recipe_recipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_category_translation ADD CONSTRAINT FK_2726HFL4323KJKEF FOREIGN KEY (origin_id) REFERENCES recipe_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_book_translation ADD CONSTRAINT FK_3726HFL4323KJKEF FOREIGN KEY (origin_id) REFERENCES recipe_book (id) ON DELETE CASCADE');
        $this->addSql('CREATE TABLE recipe_user_follow_book (user_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', book_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', PRIMARY KEY (book_id, user_id), FOREIGN KEY (user_id) REFERENCES recipe_user(id) ON DELETE CASCADE, FOREIGN KEY (book_id) REFERENCES recipe_book(id) ON DELETE CASCADE) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe_recipe_book (recipe_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', book_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', PRIMARY KEY (book_id, recipe_id), FOREIGN KEY (recipe_id) REFERENCES recipe_recipe(id) ON DELETE CASCADE, FOREIGN KEY (book_id) REFERENCES recipe_book(id) ON DELETE CASCADE) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe_recipe_category (recipe_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', category_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', PRIMARY KEY (category_id, recipe_id), FOREIGN KEY (recipe_id) REFERENCES recipe_recipe(id) ON DELETE CASCADE, FOREIGN KEY (category_id) REFERENCES recipe_category(id) ON DELETE CASCADE) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');

    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recipe_category DROP FOREIGN KEY FK_70DCBC5F727ACA70');
        $this->addSql('ALTER TABLE recipe_step DROP FOREIGN KEY FK_3CA2A4E359D8A214');
        $this->addSql('DROP TABLE recipe_category');
        $this->addSql('DROP TABLE recipe_book_translation');
        $this->addSql('DROP TABLE recipe_recipe_translation');
        $this->addSql('DROP TABLE recipe_user');
        $this->addSql('DROP TABLE recipe_step');
        $this->addSql('DROP TABLE recipe_recipe');
        $this->addSql('DROP TABLE recipe_category_translation');
        $this->addSql('DROP TABLE recipe_book');
        $this->addSql('DROP TABLE recipe_step_translation');
    }
}
