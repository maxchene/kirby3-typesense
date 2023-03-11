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
            // check that page is in options

            $config = option('maxchene.typesense.templates');
            $templates = array_keys($config);
            $template = $newPage->template()->name();

            if (in_array($template, $templates)) {
                $normalizer = $config[$template]['normalizer'];
                $client = new \Maxchene\Typesense\TypesenseClient();

                $data = $normalizer($newPage);
                $data = array_merge($data, [
                    'id' => $newPage->uuid()->id(),
                    'title' => $newPage->title()->value(),
                ]);
                dd($data instanceof \Closure);


                //upsert data
            }

            return $newPage;
        },
        'page.changeStatus:after' => function (Page $newPage, Page $oldPage) {
            // if draft delete typesense document

            // if not draft and document doesn't exists, create typesense document
        }
    ]
]);
