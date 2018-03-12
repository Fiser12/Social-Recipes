<?php declare(strict_types = 1);

namespace Recipes\Infrastructure\Persistence\Sql\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180304222129 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql('CREATE TABLE recipe_category (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe_book_translation (locale VARCHAR(255) NOT NULL, origin_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', title_title VARCHAR(255) NOT NULL, subtitle_subtitle VARCHAR(255) NOT NULL, INDEX IDX_A2F3533556A273CC (origin_id), PRIMARY KEY(locale, origin_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe_recipe_translation (locale VARCHAR(255) NOT NULL, origin_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', title_title VARCHAR(255) NOT NULL, subtitle_subtitle VARCHAR(255) NOT NULL, description_description VARCHAR(255) NOT NULL, INDEX IDX_B1F2251256A273CC (origin_id), PRIMARY KEY(locale, origin_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe_step (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', recipe_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', ingredients JSON NOT NULL COMMENT \'(DC2Type:json_object)\', tools JSON NOT NULL COMMENT \'(DC2Type:json_object)\', INDEX IDX_3CA2A4E359D8A214 (recipe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe_recipe (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', ingredients JSON NOT NULL COMMENT \'(DC2Type:json_object)\', tools JSON NOT NULL COMMENT \'(DC2Type:json_object)\', hashtags JSON NOT NULL COMMENT \'(DC2Type:json_object)\', owner_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', scope_scope VARCHAR(255) NOT NULL, servings_servings INT NOT NULL, time_seconds INT NOT NULL, difficulty_difficulty VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe_category_translation (locale VARCHAR(255) NOT NULL, origin_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', name_name VARCHAR(255) NOT NULL, INDEX IDX_442472BA56A273CC (origin_id), PRIMARY KEY(locale, origin_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe_book (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', owner_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', scope_scope VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe_step_translation (locale VARCHAR(255) NOT NULL, origin_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', description_description VARCHAR(255) NOT NULL, INDEX IDX_F1D3066956A273CC (origin_id), PRIMARY KEY(locale, origin_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe_recipe_category (recipe_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', category_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', INDEX IDX_19A8E93359D8A214 (recipe_id), INDEX IDX_19A8E93312469DE2 (category_id), PRIMARY KEY(recipe_id, category_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe_recipe_book (recipe_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', book_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', INDEX IDX_600CB78A59D8A214 (recipe_id), INDEX IDX_600CB78A16A2B381 (book_id), PRIMARY KEY(recipe_id, book_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe_user_follow_book (user_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', book_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', INDEX IDX_1854C0DFA76ED395 (user_id), INDEX IDX_1854C0DF16A2B381 (book_id), PRIMARY KEY(user_id, book_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE recipe_book_translation ADD CONSTRAINT FK_A2F3533556A273CC FOREIGN KEY (origin_id) REFERENCES recipe_book (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_recipe_translation ADD CONSTRAINT FK_B1F2251256A273CC FOREIGN KEY (origin_id) REFERENCES recipe_recipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_step ADD CONSTRAINT FK_3CA2A4E359D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe_recipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_category_translation ADD CONSTRAINT FK_442472BA56A273CC FOREIGN KEY (origin_id) REFERENCES recipe_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_step_translation ADD CONSTRAINT FK_F1D3066956A273CC FOREIGN KEY (origin_id) REFERENCES recipe_step (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_recipe_category ADD CONSTRAINT FK_19A8E93359D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe_recipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_recipe_category ADD CONSTRAINT FK_19A8E93312469DE2 FOREIGN KEY (category_id) REFERENCES recipe_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_recipe_book ADD CONSTRAINT FK_600CB78A59D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe_recipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_recipe_book ADD CONSTRAINT FK_600CB78A16A2B381 FOREIGN KEY (book_id) REFERENCES recipe_book (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_user_follow_book ADD CONSTRAINT FK_1854C0DF16A2B381 FOREIGN KEY (book_id) REFERENCES recipe_book (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema)
    {
        $this->addSql('ALTER TABLE recipe_category_translation DROP FOREIGN KEY FK_442472BA56A273CC');
        $this->addSql('ALTER TABLE recipe_recipe_category DROP FOREIGN KEY FK_19A8E93312469DE2');
        $this->addSql('ALTER TABLE recipe_step_translation DROP FOREIGN KEY FK_F1D3066956A273CC');
        $this->addSql('ALTER TABLE recipe_recipe_translation DROP FOREIGN KEY FK_B1F2251256A273CC');
        $this->addSql('ALTER TABLE recipe_step DROP FOREIGN KEY FK_3CA2A4E359D8A214');
        $this->addSql('ALTER TABLE recipe_recipe_category DROP FOREIGN KEY FK_19A8E93359D8A214');
        $this->addSql('ALTER TABLE recipe_recipe_book DROP FOREIGN KEY FK_600CB78A59D8A214');
        $this->addSql('ALTER TABLE recipe_book_translation DROP FOREIGN KEY FK_A2F3533556A273CC');
        $this->addSql('ALTER TABLE recipe_recipe_book DROP FOREIGN KEY FK_600CB78A16A2B381');
        $this->addSql('ALTER TABLE recipe_user_follow_book DROP FOREIGN KEY FK_1854C0DF16A2B381');
        $this->addSql('DROP TABLE recipe_category');
        $this->addSql('DROP TABLE recipe_book_translation');
        $this->addSql('DROP TABLE recipe_recipe_translation');
        $this->addSql('DROP TABLE recipe_user');
        $this->addSql('DROP TABLE recipe_step');
        $this->addSql('DROP TABLE recipe_recipe');
        $this->addSql('DROP TABLE recipe_category_translation');
        $this->addSql('DROP TABLE recipe_book');
        $this->addSql('DROP TABLE recipe_step_translation');
        $this->addSql('DROP TABLE recipe_recipe_category');
        $this->addSql('DROP TABLE recipe_recipe_book');
        $this->addSql('DROP TABLE recipe_user_follow_book');
    }
}
