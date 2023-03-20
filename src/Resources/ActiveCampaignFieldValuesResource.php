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
        $fieldValue = $this->request(
            method: 'get',
            path: 'fieldValues/'.$id,
            responseKey: 'fieldValue'
        );

        return FieldValueFactory::make($fieldValue);
    }

    /**
     * Create a field value and get the id.
     *
     *
     * @throws ActiveCampaignException
     */
    public function create(int $contactId, string $field, string $value): string
    {
        $fieldValue = $this->request(
            method: 'post',
            path: 'fieldValues',
            data: [
                'fieldValue' => [
                    'contact' => $contactId,
                    'field' => $field,
                    'value' => $value,
                ],
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
        $fieldValue = $this->request(
            method: 'put',
            path: 'fieldValues/'.$fieldValue->contactId,
            data: [
                'fieldValue' => [
                    'contact' => $fieldValue->contactId,
                    'field' => $fieldValue->field,
                    'value' => $fieldValue->value,
                ],
            ],
            responseKey: 'fieldValue'
        );

        return FieldValueFactory::make($fieldValue);
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
