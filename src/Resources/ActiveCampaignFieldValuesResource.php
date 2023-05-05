<?php

namespace Label84\ActiveCampaign\Resources;

use Label84\ActiveCampaign\DataObjects\ActiveCampaignFieldValue;
use Label84\ActiveCampaign\Exceptions\ActiveCampaignException;
use Label84\ActiveCampaign\Factories\FieldValueFactory;

class ActiveCampaignFieldValuesResource extends ActiveCampaignBaseResource
{
    /**
     * Retrieve an existing field value by its ID.
     *
     * @see https://developers.activecampaign.com/reference/retrieve-a-fieldvalues
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
     * Create a field value and return its ID.
     *
     * @see https://developers.activecampaign.com/reference/create-fieldvalue
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
            responseKey: 'fieldValue'
        );

        return $fieldValue['id'];
    }

    /**
     * Update an existing field value.
     *
     * @see https://developers.activecampaign.com/reference/update-a-custom-field-value-for-contact
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
     * Delete an existing field value by its ID.
     *
     * @see https://developers.activecampaign.com/reference/delete-a-fieldvalue-1
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
