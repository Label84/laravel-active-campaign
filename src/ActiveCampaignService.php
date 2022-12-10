<?php

namespace Label84\ActiveCampaign;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Label84\ActiveCampaign\Resources\ActiveCampaignContactsResource;
use Label84\ActiveCampaign\Resources\ActiveCampaignFieldValuesResource;
use Label84\ActiveCampaign\Resources\ActiveCampaignTagsResource;

class ActiveCampaignService
{
    public function __construct(
        public string            $baseUrl,
        public string   $key,
        public int      $timeout,
        public int|null $retryTimes = null,
        public int|null $retrySleep = null,
    ) {
    }

    public function makeRequest(): PendingRequest
    {
        $request = Http::withHeaders([
            'Api-Token' => $this->key,
        ])
            ->acceptJson()
            ->baseUrl($this->baseUrl)
            ->timeout($this->timeout);

        if ($this->retryTimes != null && $this->retrySleep != null) {
            $request->retry($this->retryTimes, $this->retrySleep);
        }

        return $request;
    }

    public function contacts(): ActiveCampaignContactsResource
    {
        return new ActiveCampaignContactsResource($this);
    }

    public function fieldValues(): ActiveCampaignFieldValuesResource
    {
        return new ActiveCampaignFieldValuesResource($this);
    }

    public function tags(): ActiveCampaignTagsResource
    {
        return new ActiveCampaignTagsResource($this);
    }
}
