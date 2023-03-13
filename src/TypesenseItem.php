<?php

namespace Maxchene\Typesense;

use Kirby\Cms\App;
use Kirby\Cms\Page;

class TypesenseItem implements TypesenseItemInterface
{

    public function __construct(private readonly array $item)
    {
        /**
         * Typesense Document format:
         *
         *  {
         *    document: {
         *      id: 'value',
         *      title: 'value',
         *      customField1: 'value',
         *      customField2: 'value',
         *   },
         *   highlights:[
         *      {
         *          field: 'fieldName',
         *          snippet: "an excerpt with <mark> html element surrounding keywords",
         *      }
         *   ]
         */
    }

    /**
     * Get Kirby page UUID, without page:// prefix
     * @return string
     */
    public function getId(): string
    {
        return $this->item['document']['id'];
    }

    /**
     * Get search result title with <mark> tag
     * @return string
     */
    public function getTitle(): string
    {
        return $this->get('title');
    }

    /**
     * Get Kirby Page from uuid
     * @return Page|null
     */
    public function getPage(): Page|null
    {
        return App::instance()->site()->index()->findBy('uuid', 'page://' . $this->getId());
    }

    public function get(string $field): string
    {
        foreach ($this->item['highlights'] as $highlight) {
            if ($field === $highlight['field']) {
                return $highlight['snippet'];
            }
        }
        return '';
    }

}
