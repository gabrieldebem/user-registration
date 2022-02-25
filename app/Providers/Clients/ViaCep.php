<?php

namespace App\Providers\Clients;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class ViaCep
{
    private string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.via_cep.base_url');
    }

    private function api(): PendingRequest
    {
        return Http::baseUrl($this->baseUrl);
    }

    public function findAddress(string $cep): object
    {
        try {
            return $this->api()
                ->get("/{$cep}")
                ->object();
        }catch (\Throwable $exception) {
            throw new \Exception($exception);
        }
    }
}
