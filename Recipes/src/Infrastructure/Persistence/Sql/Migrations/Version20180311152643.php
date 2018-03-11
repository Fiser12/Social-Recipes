<?php declare(strict_types = 1);

namespace Recipes\Infrastructure\Persistence\Sql\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20180311152643 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql('ALTER TABLE recipe_recipe ADD COLUMN creation_date DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE recipe_recipe ADD COLUMN edit_date DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE recipe_book ADD COLUMN creation_date DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE recipe_book ADD COLUMN edit_date DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
    }

    public function down(Schema $schema)
    {
        $this->addSql('ALTER TABLE recipe_recipe DROP COLUMN creation_date');
        $this->addSql('ALTER TABLE recipe_recipe DROP COLUMN edit_date');
        $this->addSql('ALTER TABLE recipe_book DROP COLUMN creation_date');
        $this->addSql('ALTER TABLE recipe_book DROP COLUMN edit_date');
    }
}
