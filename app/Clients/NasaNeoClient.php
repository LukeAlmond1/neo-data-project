<?php

declare(strict_types=1);

namespace App\Clients;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class NasaNeoClient
{
    protected string $baseUrl;
    protected string $apiKey;
    protected int $retries;
    protected int $retryDelay;
    protected bool $debug;

    public function __construct()
    {
        $this->baseUrl = config('services.nasa.base_url');
        $this->apiKey = config('services.nasa.key');
        $this->retries = (int) config('services.nasa.retries', 3);
        $this->retryDelay = (int) config('services.nasa.retry_delay', 200);
        $this->debug = config('services.nasa.debug', false);
    }

    public function client(): PendingRequest
    {
        $client = Http::retry($this->retries, $this->retryDelay)
            ->baseUrl($this->baseUrl)
            ->withQueryParameters([
                'api_key' => $this->apiKey,
            ])
            ->acceptJson();

        return $this->debug ? $client->withOptions(['debug' => true]) : $client;
    }
}
