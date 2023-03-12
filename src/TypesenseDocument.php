<?php

namespace Maxchene\Typesense;

use Closure;
use Kirby\Cms\Page;

class TypesenseDocument
{

    private readonly TypesenseClient $client;

    private readonly array $schema;

    public function __construct(
        private readonly Page    $page,
        private readonly Closure $normalizer
    )
    {
        $this->client = new TypesenseClient();
        $this->buildSchema();
    }

    /**
     * Upsert is a shortcut for either update or insert
     * Meaning that if a document with current id already exists, document will be updated
     * and if not, a new document will be created
     *
     * Note that id and title fields are mandatory
     * and always added to fields you provided in config file
     *
     * @return void
     * @throws \Kirby\Exception\InvalidArgumentException
     */
    public function upsert()
    {
        $data = ($this->normalizer)($this->page);
        $data = array_merge($data, [
            'id' => $this->page->uuid()->id(),
            'title' => $this->page->title()->value(),
        ]);

        $endpoint = $this->getCollectionName() . '/documents?action=upsert';
        try {
            $this->client->post($endpoint, $data);
        } catch (TypesenseException $exception) {
            if ($exception->status === 404 && 'Not Found' === $exception->message) {
                $this->createCollection();
                $this->client->post($endpoint, $data);
            } else {
                throw $exception;
            }
        }
    }

    private function createCollection(): void
    {
        $this->client->post('', $this->schema);
    }

    private function buildSchema(): void
    {
        $schema = option('maxchene.typesense.schema');
        if (empty($schema)) {
            throw new \RuntimeException('Schema configuration is missing from config file');
        }

        if (empty($schema['name'])) {
            throw new \RuntimeException('Collection name is missing from config file');
        }

        $schema['fields'][] = ['name' => 'title', 'type' => 'string'];
        $this->schema = $schema;
    }

    private function getCollectionName(): string
    {
        return $this->schema['name'];
    }

    /**
     * Delete document from Typesense index
     * so that it won't show up in search results
     *
     * @return void
     */
    public function delete(): void
    {
        $endpoint = $this->getCollectionName() . '/documents/' . $this->page->uuid()->id();
        $this->client->delete($endpoint);
    }

}
