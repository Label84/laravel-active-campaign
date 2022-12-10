<?php

namespace Label84\ActiveCampaign\Resources;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Label84\ActiveCampaign\ActiveCampaignService;
use Label84\ActiveCampaign\Exceptions\ActiveCampaignException;

class ActiveCampaignBaseResource
{
    protected PendingRequest $client;

    public function __construct(
        protected ActiveCampaignService $service,
    ) {
        $this->client = $this->service->makeRequest();
    }

    public function request(string $method, string $path, array $data = [], ?string $responseKey = null): array
    {
        /** @var Response $response */
        $response = $this->client->$method($path, $data);

        if ($response->failed()) {
            throw new ActiveCampaignException($response->json());
        }

        return $response->throw()->json($responseKey);
    }
}