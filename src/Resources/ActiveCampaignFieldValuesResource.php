<?php

namespace Label84\ActiveCampaign\Resources;

use Label84\ActiveCampaign\DataObjects\ActiveCampaignFieldValue;
use Label84\ActiveCampaign\Exceptions\ActiveCampaignException;
use Label84\ActiveCampaign\Factories\FieldValueFactory;

class ActiveCampaignFieldValuesResource extends ActiveCampaignBaseResource
{
    /**
     * Retreive an existing field value by their id.
     *
     *
     * @throws ActiveCampaignException
     */
    public function get(int $id): ActiveCampaignFieldValue
    {
        return FieldValueFactory::make($this->request(
            method: 'get',
            path: 'fieldValues/'.$id,
            responseKey: 'fieldValue'
        ));
    }

    /**
     * Create a field value and get the id.
     *
     *
     * @throws ActiveCampaignException
     */
    public function create(int $contactId, string $fieldId, string $value, bool $useDefaults = true): string
    {
        $fieldValue = $this->request(
            method: 'post',
            path: 'fieldValues',
            data: [
                'fieldValue' => [
                    'contact' => $contactId,
                    'field' => $fieldId,
                    'value' => $value,
                ],
                'useDefaults' => $useDefaults,
            ],
            responseKey: 'contact'
        );

        return $fieldValue['id'];
    }

    /**
     * Update an existing field value.
     *
     *
     * @throws ActiveCampaignException
     */
    public function update(ActiveCampaignFieldValue $fieldValue): ActiveCampaignFieldValue
    {
        return FieldValueFactory::make($this->request(
            method: 'put',
            path: 'fieldValues/'.$fieldValue->field,
            data: [
                'fieldValue' => [
                    'contact' => $fieldValue->contactId,
                    'field' => $fieldValue->field,
                    'value' => $fieldValue->value,
                ],
            ],
            responseKey: 'fieldValue'
        ));
    }

    /**
     * Delete an existing field value by their id.
     *
     *
     * @throws ActiveCampaignException
     */
    public function delete(int $id): void
    {
        $this->request(
            method: 'delete',
            path: 'fieldValues/'.$id
        );
    }
}
