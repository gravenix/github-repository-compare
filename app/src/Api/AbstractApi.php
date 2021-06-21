<?php

declare(strict_types=1);

namespace App\Api;

use \GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

abstract class AbstractApi
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    protected function get(string $url, array $data=[]): Response
    {
        return $this->client->get($url, [
            'data' => $data,
        ]);
    }
}