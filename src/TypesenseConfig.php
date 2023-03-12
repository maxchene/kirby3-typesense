<?php

namespace Maxchene\Typesense;

use Closure;
use Kirby\Cms\Page;

class TypesenseConfig
{

    public static function getConfig(): array
    {
        return option('maxchene.typesense.templates');
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

}
