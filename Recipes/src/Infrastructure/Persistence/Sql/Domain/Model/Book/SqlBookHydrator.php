<?php

namespace Recipes\Infrastructure\Persistence\Sql\Domain\Model\Book;

use LIN3S\SharedKernel\Domain\Model\Locale\Locale;
use Recipes\Domain\Model\Book\Book;
use Recipes\Domain\Model\Book\BookId;
use Recipes\Domain\Model\Book\BookTranslation;
use Recipes\Domain\Model\Recipes\RecipeCollection;
use Recipes\Domain\Model\Recipes\RecipeId;
use Recipes\Domain\Model\Scope;
use Recipes\Domain\Model\Subtitle;
use Recipes\Domain\Model\Title;
use Recipes\Domain\Model\Translation\TranslationCollection;
use Recipes\Domain\Model\User\UserId;
use Recipes\Domain\Model\User\UsersCollection;
use Recipes\Infrastructure\Persistence\Hydrator;
use Recipes\Infrastructure\Persistence\Sql\SqlHydrator;

class SqlBookHydrator implements SqlHydrator
{
    private $hydrator;

    public function __construct(Hydrator $hydrator)
    {
        $this->hydrator = $hydrator;
    }

    public function build(array $rows) : Book
    {
        return $this->hydrator->hydrate(
            $this->organizeRows($rows)
        );
    }

    private function organizeRows(array $rows) : array
    {
        $data = [];
        foreach ($rows as $row) {
            $data = [
                'id' => $data['id'] ?? BookId::generate($row['id']),
                'owner' => $data['owner'] ?? UserId::generate($row['owner_id']),
                'scope' => $data['scope'] ?? new Scope($row['scope_scope']),
                'translations' => $data['translations'] ?? new TranslationCollection(),
                'follow' => $data['follow'] ?? new UsersCollection(),
                'recipes' => $data['recipes'] ?? new RecipeCollection()
            ];

            $translation = new BookTranslation(
                new Locale($row['locale']),
                new Title($row['title_title']),
                new Subtitle($row['subtitle_subtitle'])
            );

            $data['translations']->contains($translation) ?: $data['translations']->add($translation);
            if (isset($row['user_id'])) {
                $userId = UserId::generate($row['user_id']);
                $data['follow']->contains($userId) ?: $data['follow']->add($userId);
            }

            if (isset($row['recipe_id'])) {
                $recipeId = RecipeId::generate($row['recipe_id']);
                $data['recipes']->contains($recipeId) ?: $data['recipes']->add($recipeId);
            }

        }
        return $data;
    }

}