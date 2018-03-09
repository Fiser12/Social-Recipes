<?php

namespace Recipes\Infrastructure\Persistence\Sql\Domain\Model\Book;

use LIN3S\SharedKernel\Infrastructure\Persistence\Sql\Pdo;
use Recipes\Domain\Model\Book\BookView;

class SqlBookView implements BookView
{
    private $pdo;

    public function __construct(Pdo $pdo)
    {
        $this->pdo = $pdo;
    }

    public function list(array $criteria, int $limit = -1, int $offset = 0): array
    {
        list($ids, $owners, $scopes, $locales, $order, $orderColumn, $follow) = [
            $criteria['ids'],
            $criteria['owners'],
            $criteria['scopes'],
            $criteria['locales'],
            $criteria['order'],
            $criteria['orderColumn'],
            $criteria['follow']
        ];
        list($inIds, $inIdsParams) = $this->inGenerate($ids, 'ids');
        list($inOwners, $inOwnersParams) = $this->inGenerate($owners, 'owners');
        list($inScopes, $inScopesParams) = $this->inGenerate($scopes, 'scopes');
        list($inLocales, $inLocalesParams) = $this->inGenerate($locales, 'locales');

        $idsWhere = empty($ids) ? '' : "AND `recipe_book`.id IN ($inIds)";
        $ownersWhere = empty($inOwners) ? '' : "AND `recipe_book`.owner_id IN ($inOwners)";
        $followsWhere = empty($follow) ? '' : "AND `recipe_user_follow_book`.user_id = $follow";
        $scopesWhere = empty($inScopes) ? '' : "AND `recipe_book`.scope_scope IN ($inScopes)";
        $localesWhere = empty($inLocales) ? '' : "AND `recipe_book_translation`.locale IN ($inLocales)";

        $orderBy = empty($order) || empty($orderColumn) ? '' : "ORDER BY $orderColumn $order";
        $sql = <<<SQL
SELECT
  `recipe_book`.*,
  `recipe_book_translation`.*,
  `recipe_user_follow_book`.user_id,
  `recipe_recipe_book`.recipe_id
FROM `recipe_book`
  INNER JOIN `recipe_book_translation` ON `recipe_book`.id=`recipe_book_translation`.origin_id
  LEFT JOIN `recipe_user_follow_book` ON `recipe_book`.id=`recipe_user_follow_book`.book_id
  LEFT JOIN `recipe_recipe_book` ON `recipe_book`.id=`recipe_recipe_book`.book_id
WHERE 1 = 1
$idsWhere
$ownersWhere
$scopesWhere
$localesWhere
$followsWhere
$orderBy
LIMIT $limit OFFSET $offset
SQL;
        $parameters = array_merge($inIdsParams, $inOwnersParams, $inScopesParams, $inLocalesParams);

        return $this->organizeRows(
            $this->pdo->query(
                $sql,
                $parameters
            )
        );
    }

    private function inGenerate(array $elements, string $discriminator)
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
                'scope' => $data[$row['id']]['scope'] ?? $row['scope_scope'],
                'translations' => $data[$row['id']]['translations'] ?? [],
                'follow' => $data[$row['id']]['follow'] ?? [],
                'recipes' => $data[$row['id']]['recipes'] ?? []
            ];

            $data[$row['id']]['translations'][$row['locale']] = [
                'locale' => $row['locale'],
                'title' => $row['title_title'],
                'subtitle' => $row['subtitle_subtitle']
            ];

            if (isset($row['user_id'])) {
                in_array($row['user_id'], $data[$row['id']]['follow'])
                    ?: $data[$row['id']]['follow'][] = $row['user_id'];
            }

            if (isset($row['recipe_id'])) {
                in_array($row['recipe_id'], $data[$row['id']]['recipes'])
                    ?: $data[$row['id']]['recipes'][] = $row['recipe_id'];
            }

        }
        return $data;
    }

}
