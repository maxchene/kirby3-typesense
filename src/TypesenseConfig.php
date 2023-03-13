<?php

namespace Maxchene\Typesense;

use Closure;
use Kirby\Cms\Page;
use Kirby\Toolkit\A;

class TypesenseConfig
{

    public static function getConfig(): array
    {
        return option('maxchene.typesense.templates');
    }

    public static function getCollectionName(): string|null
    {
        return option('maxchene.typesense.schema.name');
    }

    public static function getTemplates(): array
    {
        return array_keys(self::getConfig());
    }


    public static function isIndexable(Page $page): bool
    {
        return in_array($page->template()->name(), self::getTemplates());
    }

    public static function getNormalizer(Page $page): Closure
    {
        return self::getConfig()[$page->template()->name()];
    }

    public static function getFields(): array
    {
        $fields = ['title'];
        $config = option('maxchene.typesense.schema.fields');
        if (is_array($config)) {
            $configFields = A::pluck($config, 'name');
            $fields = array_merge($fields, $configFields);
        }

        return $fields;

    }

}
