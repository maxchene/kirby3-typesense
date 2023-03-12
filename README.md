# Kirby Typesense

This plugin allow you to index kirby pages into typesense and make fulltext search available for your website.

## Overview

## 1. Install Typesense on your server

## 2. Install the Kirby Typesense plugin

Download and copy this repository to ```/site/plugins/typesense```

Even better, install it with composer: ```composer require maxchene/kirby3-typesense```

## 3. Configuration

Edit your config file: ```site/config/config.php``` to add your own plugin configuration.

Here is what it should look like:

```php
'maxchene.typesense' => [
        'host' => 'typesense:8108',
        'key' => 'secret',
        'schema' => [
            'name' => 'my-collection',
            'fields' => [
                // ['name' => 'id', 'type' => 'string'], no need since typesense automatically add id
                // ['name' => 'title', 'type' => 'string'], no need, title is always added to document
                ['name' => 'content', 'type' => 'string'],
                ['name' => 'type', 'type' => 'string']
            ]
        ],
        'templates' => [
            'article' => function (Page $page) {

            },
            'default' => function (Page $page) {
                return [
                    'content' => 'text content that should be indexed for fulltext search',
                    'type' => 'default'
                ];
            }
        ]
    ]
```

### 3.1 Schema configuration

### 3.2 Templates configuration
