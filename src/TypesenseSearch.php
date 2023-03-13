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
            // 'query_by' => 'title,content,zones,themes',
            'query_by' => 'title,content',
            'num_typos' => option('maxchene.typesense.num_typos'),
            'per_page' => $limit,
            'page' => $page
        ]);
        $url = "{$this->searchUrl}{$query->toString(true)}";
        $data = $this->client->get($url);
        return $data;
    }

}
