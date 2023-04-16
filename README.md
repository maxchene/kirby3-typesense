# Kirby Typesense

This plugin allow you to index kirby pages into typesense and make fulltext search available for your website.

## Overview

> This plugin is free and under MIT license, I'm glad if you find it usefull. If you plan to use it for commercial use,
> or if I saved you some time,
> please consider helping me to maintain this by either [making a donation](https://www.paypal.com/paypalme/maximechene)
> of your choice or [sponsoring me](https://github.com/sponsors/maxchene).

## 1. Install Typesense on your server

### 1.1 What is Typesense ?

[Typesense](https://typesense.org) is an opensource alternative for Algolia or ElasticSearch. It is free and provide a
fast typo tolerant search engine.

### 1.2 Install Typesense

To use this plugin, you need
to [install Typesense on your server](https://typesense.org/docs/guide/install-typesense.html).

<br/>

## 2. Install the Kirby Typesense plugin

Download and copy this repository to ```/site/plugins/typesense```

Or even better, to get easy updates, install it with composer: ```composer require maxchene/kirby3-typesense```

<br/>

## 3. Configuration

Edit your config file: ```site/config/config.php``` to add your own plugin configuration.

Here is what it should look like:

```php
'maxchene.typesense' => [
        'host' => 'localhost:8108', # typesense host and port
        'key' => 'secret', # typesense API key
        'num_typos' => 2, # number of allowed typo error
        'schema' => [
            'name' => 'my-collection',
            'fields' => [
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

<br/>

### 3.1 Schema configuration

### 3.2 Templates configuration

## 4. Use fulltext search

All fields provided in the config file will be searched.

| Param  | Description                        | Type    | Optionnal | Default value |
|--------|------------------------------------|---------|-----------|---------------|
| $query | your search string                 | string  | no        |               |
| $limit | Maximum number of results per page | integer | yes       | 30            |
| $page  | Page number                        | integer | yes       | 1             |

<br>

### 4.1 Site method

This plugins gives you access to the ```$site->typesenseSearch(string $query, int $limit, int $page)``` method
wherever ```$site``` is available: templates, controllers,...

<br>

### 4.2 Typesense Search

You can also create a TypesenseSearch instance :

````php
 $searchEngine = new TypesenseSearch();
 $results =  $searchEngine->search($query, $limit, $page);

````

## 5. Command Line

## 6. Full configuration exemple

## 7. TODOS

- add command line tools
- improve docs or enable wiki pages for this repo
- maybe add a Page method to build indexed content
