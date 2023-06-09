<?php

namespace Maxchene\Typesense;

use Kirby\Http\Query;
use Kirby\Toolkit\A;
use RuntimeException;

class TypesenseSearch
{

    private readonly TypesenseClient $client;

    private string $searchUrl;

    public function __construct()
    {
        $this->client = new TypesenseClient();
        $collection = TypesenseConfig::getCollectionName();
        if (empty($collection)) {
            throw new RuntimeException('Missing collection name from config file.');
        }
        $this->searchUrl = "{$collection}/documents/search";
    }

    public function search(string $q, int $limit = 30, int $page = 1)
    {

        $fields = A::join(TypesenseConfig::getFields(), ',');
        $query = new Query([
            'q' => $q,
            'query_by' => $fields,
            'num_typos' => option('maxchene.typesense.num_typos'),
            'per_page' => $limit,
            'page' => $page
        ]);
        $url = "{$this->searchUrl}{$query->toString(true)}";
        ['found' => $resultsCount, 'hits' => $searchItems] = $this->client->get($url);
        return new SearchResult(array_map(fn(array $item) => new TypesenseItem($item), $searchItems), $resultsCount);
    }

}
