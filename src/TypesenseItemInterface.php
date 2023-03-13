<?php

namespace Maxchene\Typesense;

use Kirby\Cms\Page;

interface TypesenseItemInterface
{

    public function getTitle(): string;

    public function getId(): string;

    public function getPage(): Page|null;

    public function get(string $field): string;

}
