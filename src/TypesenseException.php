<?php

namespace Maxchene\Typesense;

use Kirby\Http\Remote;

final class TypesenseException extends \RuntimeException
{
    public int $status;

    /**
     * @var string
     */
    public $message;

    /**
     * @throws \JsonException
     */
    public function __construct(Remote $response)
    {
        $this->status = $response->code();
        $this->message = json_decode($response->errorMessage, true, 512, JSON_THROW_ON_ERROR)['message'] ?? '';
    }
}
