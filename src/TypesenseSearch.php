<?php

namespace Maxchene\Typesense;

use Kirby\Http\Query;

class TypesenseSearch
{

    private readonly TypesenseClient $client;

    public function __construct()
    {
        $this->client = new TypesenseClient();
    }

    public static function search(string $q, int $limit = 30, int $page = 1)
    {
        $query = new Query([
            'q' => $q,
            // 'query_by' => 'title,content,zones,themes',
            'query_by' => 'title,content',
            'num_typos' => 2,
            'per_page' => $limit,
            'page' => $page
        ]);
        dump($query->toString(true));
    }

}
