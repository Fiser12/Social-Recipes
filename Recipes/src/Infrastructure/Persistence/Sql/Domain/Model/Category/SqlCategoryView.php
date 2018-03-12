<?php

namespace Recipes\Infrastructure\Persistence\Sql\Domain\Model\Category;

use LIN3S\SharedKernel\Infrastructure\Persistence\Sql\Pdo;
use Recipes\Domain\Model\Book\Book;
use Recipes\Domain\Model\Book\BookId;
use Recipes\Domain\Model\Book\BookRepository;
use Recipes\Domain\Model\Book\BookTranslation;
use Recipes\Domain\Model\Book\BookView;
use Recipes\Domain\Model\Category\CategoryView;
use Recipes\Domain\Model\Recipes\RecipeId;
use Recipes\Domain\Model\User\UserId;
use Recipes\Infrastructure\Persistence\Sql\SqlHydrator;

class SqlCategoryView implements CategoryView
{
    private $pdo;

    public function __construct(Pdo $pdo)
    {
        $this->pdo = $pdo;
    }

    public function list(array $criteria, int $limit = -1, int $offset = 0): array
    {
        list($ids, $locales, $order, $orderColumn) = [
            $criteria['ids'] ?? null,
            $criteria['locales'] ?? null,
            $criteria['order'] ?? null,
            $criteria['orderColumn'] ?? null
        ];
        list($inIds, $inIdsParams) = $this->inGenerate($ids, 'ids');
        list($inLocales, $inLocalesParams) = $this->inGenerate($locales, 'locales');

        $idsWhere = empty($ids) ? '' : "AND `recipe_category`.id IN ($inIds) ";
        $localesWhere = empty($inLocales) ? '' : "AND `recipe_category_translation`.locale IN ($inLocales) ";
        $limitClosure = $limit === -1 ? '' : "LIMIT $limit OFFSET $offset ";
        $orderBy = empty($order) || empty($orderColumn) ? '' : "ORDER BY $orderColumn $order ";

        $sql = <<<SQL
SELECT 
`recipe_category`.*,
`recipe_category_translation`.*,
`recipe_recipe_category`.recipe_id 
FROM `recipe_category`
  LEFT JOIN `recipe_category_translation` ON `recipe_category`.id=`recipe_category_translation`.origin_id
  LEFT JOIN `recipe_recipe_category` ON `recipe_category`.id=`recipe_recipe_category`.category_id
 
WHERE 1 = 1 
$idsWhere
$localesWhere
$orderBy
$limitClosure
SQL;
        $parameters = array_merge($inIdsParams, $inLocalesParams);

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
            $in_params[$key] = $item;
        }
        $in = rtrim($in, ",");

        return [$in, $in_params];
    }

    public function organizeRows(array $rows): array
    {
        $data = [];
        foreach ($rows as $row) {
            $data[$row['id']] = [
                'id' => $data['id'] ?? $row['id'],
                'translations' => $data[$row['id']]['translations'] ?? [],
                'recipes' => $data[$row['id']]['recipes'] ?? []
            ];

            $data[$row['id']]['translations'][$row['locale']] = [
                'locale' => $row['locale'],
                'name' => $row['name_name']
            ];

            if (isset($row['recipe_id'])) {
                in_array($row['recipe_id'], $data[$row['id']]['recipes'])
                    ?: $data['recipes'][] = $row['recipe_id'];
            }

        }
        return $data;
    }

}
