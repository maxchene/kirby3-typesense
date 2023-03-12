<?php

namespace Maxchene\Typesense;

use Kirby\Http\Remote;

class TypesenseClient
{

    private readonly string $apiKey;

    private readonly string $host;

    public function __construct()
    {
        $apiKey = option('maxchene.typesense.key');
        $host = option('maxchene.typesense.host');

        if (empty($apiKey)) {
            throw new \RuntimeException('Typesense API key is missing from config file');
        }
        $this->apiKey = $apiKey;
        $this->host = $host;
    }

    public function get(string $endpoint): array
    {
        return $this->request($endpoint);
    }

    public function post(string $endpoint, array $data = []): array
    {
        return $this->request($endpoint, $data, 'POST');
    }

    public function patch(string $endpoint, array $data = []): array
    {
        return $this->request($endpoint, $data, 'PATCH');
    }

    public function delete(string $endpoint, array $data = []): array
    {
        return $this->request($endpoint, $data, 'DELETE');
    }

    public function request(string $endpoint, array $data = [], string $method = 'GET'): array
    {

        $requestParams = [
            'headers' => [
                'X-TYPESENSE-API-KEY' => $this->apiKey,
                'Content-Type' => 'application/json'
            ],
            'method' => $method,
            'data' => json_encode($data)
        ];
        $response = Remote::request("{$this->host}/collections/{$endpoint}", $requestParams);

        if ($response->code() >= 200 && $response->code() < 300) {
            return $response->json();
        }

        throw new TypesenseException($response);

    }

}
