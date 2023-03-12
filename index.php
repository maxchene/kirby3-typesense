<?php

use Kirby\Cms\App;
use Kirby\Cms\Event;
use Kirby\Cms\Page;
use Maxchene\Typesense\TypesenseDocument;

@include_once __DIR__ . '/vendor/autoload.php';

App::plugin('maxchene/typesense', [
    'options' => [
        'host' => 'localhost:8108'
    ],
    'siteMethods' => [
        'typesenseSearch' => function (string $query, array $fields = []): array {
            return $this->seoTitle()->isNotEmpty() ? $this->seoTitle() : $this->title();
        }
    ],
    'hooks' => [
        'page.*:after' => function (Event $event, Page $newPage) {

            if (in_array($event->action(), ['update', 'delete', 'changeStatus', 'changeTitle', 'changeTemplate'])) {
                $config = option('maxchene.typesense.templates');
                $templates = array_keys($config);
                $template = $newPage->template()->name();

                // check that page template is in config file
                if (in_array($template, $templates)) {
                    $document = new TypesenseDocument($newPage, $config[$template]);

                    if (
                        $event->action() === 'update' ||
                        $event->action() === 'changeTitle' ||
                        $event->action() === 'changeTemplate' ||
                        $event->action() === 'changeStatus' && in_array($newPage->status(), ['listed', 'unlisted'])
                    ) {
                        $document->upsert();
                    } else {
                        $document->delete();
                    }

                }
            }
        }
    ]
]);
