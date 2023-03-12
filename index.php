<?php

use Kirby\Cms\App;
use Kirby\Cms\Page;
use Maxchene\Typesense\TypesenseConfig;
use Maxchene\Typesense\TypesenseDocument;

@include_once __DIR__ . '/vendor/autoload.php';

App::plugin('maxchene/typesense', [
    'options' => [
        'host' => 'localhost:8108'
    ],
    'siteMethods' => [
        'typesenseSearch' => function (string $query): array {
            return [];
        }
    ],
    'hooks' => [
        'page.update:after' => function (Page $newPage) {
            if (TypesenseConfig::isIndexable($newPage) && $newPage->isPublished()) {
                $document = new TypesenseDocument($newPage);
                $document
                    ->setNormalizer(TypesenseConfig::getNormalizer($newPage))
                    ->upsert();
            }
        },
        'page.changeTitle:after' => function (Page $newPage) {
            if (TypesenseConfig::isIndexable($newPage)) {
                $document = new TypesenseDocument($newPage);
                $document
                    ->setNormalizer(TypesenseConfig::getNormalizer($newPage))
                    ->upsert();
            }
        },
        'page.delete:after' => function (bool $status, Page $page) {
            if ($status) {
                $document = new TypesenseDocument($page);
                $document->delete();
            }
        },
        'page.changeTemplate:after' => function (Page $newPage) {

            $document = new TypesenseDocument($newPage);
            // if new template is not indexable, remove document
            if (!TypesenseConfig::isIndexable($newPage)) {
                $document->delete();
            } else {
                $document
                    ->setNormalizer(TypesenseConfig::getNormalizer($newPage))
                    ->upsert();
            }

        },
        'page.changeStatus:after' => function (Page $newPage, Page $oldPage) {


            // if new status is published and page is indexable, upsert
            if ($newPage->isPublished() && TypesenseConfig::isIndexable($newPage)) {
                $document = new TypesenseDocument($newPage);
                $document
                    ->setNormalizer(TypesenseConfig::getNormalizer($newPage))
                    ->upsert();
            }

            // if new status is unpublished, delete document
            if ($newPage->isDraft()) {
                $document = new TypesenseDocument($newPage);
                $document->delete();
            }

        }
    ]
]);
