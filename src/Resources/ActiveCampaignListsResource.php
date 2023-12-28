<?php

namespace Label84\ActiveCampaign\Resources;

use Illuminate\Support\Collection;
use Label84\ActiveCampaign\DataObjects\ActiveCampaignList;
use Label84\ActiveCampaign\Exceptions\ActiveCampaignException;
use Label84\ActiveCampaign\Factories\ListFactory;

class ActiveCampaignListsResource extends ActiveCampaignBaseResource
{
    /**
     * Retrieve an existing list by its ID.
     *
     * @see https://developers.activecampaign.com/reference/retrieve-a-list
     *
     * @throws ActiveCampaignException
     */
    public function get(string $id): ActiveCampaignList
    {
        return ListFactory::make($this->request(
            method: 'get',
            path: 'lists/'.$id,
            responseKey: 'list'
        ));
    }

    /**
     * List all lists, search lists, or filter lists by query defined criteria.
     *
     * @see https://developers.activecampaign.com/reference/retrieve-all-lists
     *
     * @return Collection<int, ActiveCampaignList>
     *
     * @throws ActiveCampaignException
     */
    public function list(?string $query = ''): Collection
    {
        $lists = $this->request(
            method: 'get',
            path: 'lists?'.$query,
            responseKey: 'lists'
        );

        return collect($lists)
            ->map(fn ($list) => ListFactory::make($list));
    }

    /**
     * Create a list and return the list ID.
     *
     * @see https://developers.activecampaign.com/reference/create-new-list
     *
     * @throws ActiveCampaignException
     */
    public function create(string $email, array $attributes = []): string
    {
        $list = $this->request(
            method: 'post',
            path: 'lists',
            data: [
                'list' => $attributes,
            ],
            responseKey: 'list'
        );

        return $list['id'];
    }

    /**
     * Delete an existing list by its ID.
     *
     * @see https://developers.activecampaign.com/reference/delete-a-list
     *
     * @throws ActiveCampaignException
     */
    public function delete(string $id): void
    {
        $this->request(
            method: 'delete',
            path: 'lists/'.$id
        );
    }
}
