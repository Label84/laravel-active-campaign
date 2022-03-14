<?php

namespace Label84\ActiveCampaign\Resources;

use Label84\ActiveCampaign\ActiveCampaignService;
use Label84\ActiveCampaign\DataObjects\ActiveCampaignFieldValue;
use Label84\ActiveCampaign\Exceptions\ActiveCampaignException;
use Label84\ActiveCampaign\Factories\FieldValueFactory;

class ActiveCampaignFieldValuesResource
{
    public function __construct(
        private readonly ActiveCampaignService $service,
    ) {
    }

    /**
     * Retreive an existing field value by their id.
     * @param int $id
     * @return ActiveCampaignFieldValue
     */
    public function get(int $id): ActiveCampaignFieldValue
    {
        $request = $this->service->makeRequest();

        $response = $request->get("/fieldValues/{$id}");

        if ($response->failed()) {
            throw new ActiveCampaignException($response->json());
        }

        $fieldValue = json_decode($response->body(), true)['fieldValue'];

        return FieldValueFactory::make($fieldValue);
    }

    /**
     * Create a field value and get the id.
     * @param int $contactId
     * @param string $field
     * @param string $value
     * @return string
     */
    public function create(int $contactId, string $field, string $value): string
    {
        $request = $this->service->makeRequest();

        $response = $request->post('/fieldValues', ['fieldValue' => [
            'id' => $contactId,
            'field' => $field,
            'value' => $value,
        ]]);

        if ($response->failed()) {
            throw new ActiveCampaignException($response->json());
        }

        $fieldValue = json_decode($response->body(), true)['fieldValue'];

        return $fieldValue['id'];
    }

    /**
     * Update an existing field value.
     * @param ActiveCampaignFieldValue $fieldValue
     * @return ActiveCampaignFieldValue
     */
    public function update(ActiveCampaignFieldValue $fieldValue): ActiveCampaignFieldValue
    {
        $request = $this->service->makeRequest();

        $response = $request->put("/fieldValues/{$fieldValue->contactId}", ['fieldValue' => [
            'id' => $fieldValue->contactId,
            'field' => $fieldValue->field,
            'value' => $fieldValue->value,
        ]]);

        if ($response->failed()) {
            throw new ActiveCampaignException($response->json());
        }

        $fieldValue = json_decode($response->body(), true)['fieldValue'];

        return FieldValueFactory::make($fieldValue);
    }

    /**
     * Delete an existing field value by their id.
     * @param int $id
     * @return int
     */
    public function delete(int $id): int
    {
        $request = $this->service->makeRequest();

        $response = $request->delete("/fieldValues/{$id}");

        if ($response->failed()) {
            throw new ActiveCampaignException($response->json());
        }

        return $response->status();
    }
}
