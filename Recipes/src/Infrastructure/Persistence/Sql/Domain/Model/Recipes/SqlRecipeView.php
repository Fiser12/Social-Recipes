<?php

namespace Recipes\Infrastructure\Persistence\Sql\Domain\Model\Recipes;

use LIN3S\SharedKernel\Infrastructure\Persistence\Sql\Pdo;
use Recipes\Domain\Model\Book\Book;
use Recipes\Domain\Model\Book\BookId;
use Recipes\Domain\Model\Book\BookRepository;
use Recipes\Domain\Model\Book\BookTranslation;
use Recipes\Domain\Model\Book\BookView;
use Recipes\Domain\Model\Recipes\RecipeId;
use Recipes\Domain\Model\Recipes\RecipeView;
use Recipes\Domain\Model\User\UserId;
use Recipes\Infrastructure\Persistence\Sql\SqlHydrator;

class SqlRecipeView implements RecipeView
{
    private $pdo;

    public function __construct(Pdo $pdo)
    {
        $this->pdo = $pdo;
    }

    public function list(array $criteria, int $limit = 0, int $offset = 0): array
    {
        list($ids, $owners, $scopes, $difficulty, $locales, $books, $categories, $order, $orderColumn, $follow) = [
            $criteria['ids'],
            $criteria['owners'],
            $criteria['scopes'],
            $criteria['difficulty'],
            $criteria['books'],
            $criteria['categories'],
            $criteria['locales'],
            $criteria['order'],
            $criteria['orderColumn'],
            $criteria['follow']
        ];
        list($inIds, $inIdsParams) = $this->inGenerate($ids, 'ids');
        list($inOwners, $inOwnersParams) = $this->inGenerate($owners, 'owners');
        list($inScopes, $inScopesParams) = $this->inGenerate($scopes, 'scopes');
        list($inBooks, $inBooksParams) = $this->inGenerate($books, 'books');
        list($inCategories, $inCategoriesParams) = $this->inGenerate($categories, 'categories');
        list($inDifficulties, $inDifficultiesParams) = $this->inGenerate($difficulty, 'difficulty');
        list($inLocales, $inLocalesParams) = $this->inGenerate($locales, 'locales');

        $idsWhere = empty($ids) ? '' : "AND `recipe_recipe`.id IN ($inIds) ";
        $ownersWhere = empty($inOwners) ? '' : "AND `recipe_recipe`.owner_id IN ($inOwners) AND `recipe_book`.owner_id IN ($inOwners) ";
        $scopesWhere = empty($inScopes) ? '' : "AND `recipe_recipe`.scope_scope IN ($inScopes) ";
        $recipesWhere = empty($inDifficulties) ? '' : "AND `recipe_recipe`.difficulty_difficulty IN ($inDifficulties) ";
        $localesWhere = empty($inLocales) ? '' : "AND `recipe_recipe_translation`.locale IN ($inLocales) ";
        $booksWhere = empty($inBooks) ? '' : "AND `recipe_recipe_translation`.locale IN ($inBooks) ";
        $categoriesWhere = empty($inCategories) ? '' : "AND `recipe_recipe_translation`.locale IN ($inCategories) ";
        $followsWhere = empty($follow) ? '' : "AND `recipe_user_follow_book`.user_id = $follow ";
        $limitClosure = $limit === -1 ? '' : "LIMIT $limit OFFSET $offset ";

        $orderBy = empty($order) || empty($orderColumn) ? '' : "ORDER BY $orderColumn $order ";
        $sql = <<<SQL
SELECT 
  `recipe_recipe`.id,
  `recipe_recipe`.owner_id,
  `recipe_recipe`.ingredients,
  `recipe_recipe`.difficulty_difficulty,
  `recipe_recipe`.hashtags,
  `recipe_recipe`.scope_scope,
  `recipe_recipe`.servings_servings,
  `recipe_recipe`.time_seconds,
  `recipe_recipe`.tools,
  `recipe_recipe_translation`.description_description,
  `recipe_recipe_translation`.title_title,
  `recipe_recipe_translation`.subtitle_subtitle,
  `recipe_recipe_translation`.locale,
  `recipe_recipe_category`.category_id                  AS category_id,
  `recipe_category_translation`.locale                  AS category_translation_locale,
  `recipe_category_translation`.name_name               AS category_translation_name,
  `recipe_book`.id                                      AS book_id,
  `recipe_book`.scope                                   AS book_scope,
  `recipe_book_translation`.locale                      AS book_translation_locale,
  `recipe_book_translation`.title_title                 AS book_translation_title,
  `recipe_book_translation`.subtitle_subtitle           AS book_translation_subtitle,
  `recipe_step`.id                                      AS step_id,
  `recipe_step`.tools                                   AS tools_step,
  `recipe_step`.ingredients                             AS ingredients_step,
  `recipe_step_translation`.locale                      AS step_translation_locale,
  `recipe_step_translation`.description_description     AS step_translation_description

FROM `recipe_recipe` 
  LEFT JOIN `recipe_recipe_translation` ON `recipe_recipe`.id=`recipe_recipe_translation`.origin_id
  LEFT JOIN `recipe_step` ON `recipe_step`.recipe_id = `recipe_recipe`.id
  LEFT JOIN `recipe_step_translation` ON `recipe_step_translation`.origin_id = `recipe_step`.id
  LEFT JOIN `recipe_recipe_category` ON `recipe_recipe_category`.recipe_id = `recipe_recipe`.id
  LEFT JOIN `recipe_recipe_book` ON `recipe_recipe_book`.recipe_id = `recipe_recipe`.id
  LEFT JOIN `recipe_book` ON `recipe_recipe_book`.book_id = `recipe_book`.id
  LEFT JOIN `recipe_category_translation` ON `recipe_recipe_category`.category_id = `recipe_category_translation`.origin_id
 
WHERE 1 = 1 
$idsWhere
$ownersWhere
$scopesWhere
$localesWhere
$recipesWhere
$booksWhere
$categoriesWhere
$followsWhere
$orderBy
$limitClosure
SQL;
        $parameters = array_merge(
            $inIdsParams,
            $inOwnersParams,
            $inScopesParams,
            $inLocalesParams,
            $inDifficultiesParams,
            $inBooksParams,
            $inCategoriesParams,
            [$follow]
        );

        return $this->organizeRows(
            $this->pdo->query(
                $sql,
                $parameters
            )
        );
    }

    private function inGenerate(?array $elements, string $discriminator)
    {
        if (empty($elements)) {
            return ['', []];
        }

        $in = "";
        $in_params = [];

        foreach ($elements as $i => $item) {
            $key = ":" . $discriminator . $i;
            $in .= "$key,";
            $in_params[$key] = $item; // collecting values into key-value array
        }
        $in = rtrim($in, ",");

        return [$in, $in_params];
    }

    public function organizeRows(array $rows): array
    {
        $data = [];

        foreach ($rows as $row) {
            $data[$row['id']] = [
                'id' => $data[$row['id']]['id'] ?? $row['id'],
                'owner' => $data[$row['id']]['owner'] ?? $row['owner_id'],
                'difficulty' => $data[$row['id']]['difficulty'] ?? $row['difficulty_difficulty'],
                'servings' => $data[$row['id']]['servings'] ?? $row['servings_servings'],
                'scope' => $data[$row['id']]['scope'] ?? $row['scope_scope'],
                'time' => $data[$row['id']]['time'] ?? $row['time_seconds'],
                'translations' => $data[$row['id']]['translations'] ?? [],
                'steps' => $data[$row['id']]['steps'] ?? [],
                'ingredients' => json_decode($row['ingredients'], true),
                'tools' => json_decode($row['tools'], true),
                'hashtags' => json_decode($row['hashtags'], true),
                'creationDate' => $data[$row['id']]['creationDate'] ?? $row['creation_date'],
                'editDate' => $data[$row['id']]['editDate'] ?? $row['edit_date']
            ];

            $data[$row['id']]['translations'][$row['locale']] = [
                'locale' => $row['locale'],
                'title' => $row['title_title'],
                'subtitle' => $row['subtitle_subtitle'],
                'description' => $row['description_description']
            ];

            $data[$row['id']]['steps'][$row['step_id']] = [
                'tools' => json_decode($row['tools'], true),
                'ingredients' => json_decode($row['ingredients_step'], true)
            ];

            $data[$row['id']]['steps'][$row['step_id']]['translations'][$row['step_translation_locale']] = [
                'locale' => $row['step_translation_locale'],
                'description' => $row['step_translation_description']
            ];

            $data[$row['id']]['books'][$row['book_id']] = [
                'id' => $row['book_id'],
                'scope' => $row['book_scope']
            ];

            $data[$row['id']]['books'][$row['book_id']]['translations'][$row['book_translation_locale']] = [
                'locale'    => $row['book_translation_locale'],
                'title'     => $row['book_translation_title'],
                'subtitle'  => $row['book_translation_subtitle']
            ];

            $data[$row['id']]['categories'][$row['category_id']] = [
                'id' => $row['category_id']
            ];

            $data[$row['id']]['categories'][$row['category_id']]['translations'][$row['category_translation_locale']] = [
                'locale' => $row['category_translation_locale'],
                'name' => $row['category_translation_name']
            ];

        }
        return $data;
    }

}
