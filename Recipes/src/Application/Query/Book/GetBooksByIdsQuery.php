<?php

namespace Recipes\Application\Query\Book;

class GetBooksByIdsQuery
{
    private $ids;
    private $userId;

    public function __construct(
        array $ids,
        ?string $userId
    )
    {
        $this->ids = $ids;
        $this->userId = $userId;
    }

    public function ids(): array
    {
        return $this->ids;
    }

    public function userId(): ?string
    {
        return $this->userId;
    }

}