<?php

use Kirby\Cms\App;
use Kirby\Cms\Page;

@include_once __DIR__ . '/vendor/autoload.php';

App::plugin('maxchene/typesense', [
    'options' => [
        'host' => 'localhost:8108'
    ],
    'hooks' => [
        'page.delete:before' => function (Page $page) {
            // delete typesense document
        },
        'page.update:after' => function (Kirby\Cms\Page $newPage, Kirby\Cms\Page $oldPage) {
            // your code goes here
            $client = new \Maxchene\Typesense\TypesenseClient();
            $response = $client->get('health');
            dump($response);
            return $newPage;
        },
        'page.changeStatus:after' => function (Page $newPage, Page $oldPage) {
            // if draft delete typesense document

            // if not draft and document doesn't exists, create typesense document
        }
    ]
]);
