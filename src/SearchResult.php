<?php

namespace Maxchene\Typesense;

class SearchResult
{

    /**
     * @param TypesenseItemInterface[] $items
     */
    public function __construct(private readonly array $items, private readonly int $resultsCount)
    {
    }

    /**
     * @return TypesenseItemInterface[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function getTotal(): int
    {
        return $this->resultsCount;
    }

}
