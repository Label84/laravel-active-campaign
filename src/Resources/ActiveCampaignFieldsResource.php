<?php

namespace Label84\ActiveCampaign\Resources;

use Illuminate\Support\Collection;
use Label84\ActiveCampaign\DataObjects\ActiveCampaignField;
use Label84\ActiveCampaign\Exceptions\ActiveCampaignException;
use Label84\ActiveCampaign\Factories\FieldFactory;

class ActiveCampaignFieldsResource extends ActiveCampaignBaseResource
{
    /**
     * List all fields, search fields, or filter fields by query defined criteria.
     *
     * @see https://developers.activecampaign.com/reference/retrieve-fields
     *
     * @throws ActiveCampaignException
     * @return Collection<int, ActiveCampaignField>
     */
    public function list(?string $query = ''): Collection
    {
        $fields = $this->request(
            method: 'get',
            path: 'fields?' . $query,
            responseKey: 'fields'
        );

        return collect($fields)
            ->map(fn ($field) => FieldFactory::make($field));
    }

    /**
     * Retrieve an existing field value by its ID.
     *
     * @see https://developers.activecampaign.com/reference/retrieve-a-custom-field-contact
     *
     * @throws ActiveCampaignException
     */
    public function get(int $id): ActiveCampaignField
    {
        return FieldFactory::make($this->request(
            method: 'get',
            path: 'fields/' . $id,
            responseKey: 'field'
        ));
    }

    /**
     * Create a field value and return its ID.
     *
     * @see https://developers.activecampaign.com/reference/create-a-contact-custom-field
     *
     * @throws ActiveCampaignException
     */
    public function create(string $type, string $title, string $description, array $attributes = []): string
    {
        $fieldValue = $this->request(
            method: 'post',
            path: 'fields',
            data: [
                'field' => [
                        'type' => $type,
                        'title' => $title,
                        'descript' => $description,
                    ] + $attributes,
            ],
            responseKey: 'fieldValue'
        );

        return $fieldValue['id'];
    }

    /**
     * Update an existing field.
     *
     * @see https://developers.activecampaign.com/reference/update-a-field
     *
     * @throws ActiveCampaignException
     */
    public function update(ActiveCampaignField $field): ActiveCampaignField
    {
        return FieldFactory::make($this->request(
            method: 'put',
            path: 'fields/' . $field->id,
            data: [
                'field' => [
                    "type" => $field->type,
                    "title" => $field->title,
                    "descript" => $field->description,
                    "perstag" => $field->perstag,
                    "defval" => $field->defaultValue,
                    "show_in_list" => $field->showInList,
                    "rows" => $field->rows,
                    "cols" => $field->cols,
                    "visible" => $field->visible,
                    "service" => $field->service,
                    "ordernum" => $field->orderNumber,
                ],
            ],
            responseKey: 'fieldValue'
        ));
    }

    /**
     * Delete an existing field value by its ID.
     *
     * @see https://developers.activecampaign.com/reference/delete-a-field
     *
     * @throws ActiveCampaignException
     */
    public function delete(int $id): void
    {
        $this->request(
            method: 'delete',
            path: 'fields/' . $id
        );
    }
}
