<?php

namespace Label84\ActiveCampaign\Resources;

use Illuminate\Support\Collection;
use Label84\ActiveCampaign\DataObjects\ActiveCampaignTag;
use Label84\ActiveCampaign\Exceptions\ActiveCampaignException;
use Label84\ActiveCampaign\Factories\TagFactory;

class ActiveCampaignTagsResource extends ActiveCampaignBaseResource
{
    /**
     * Retreive an existing tag by their id.
     *
     * @param  int  $id
     * @return ActiveCampaignTag
     *
     * @throws ActiveCampaignException
     */
    public function get(int $id): ActiveCampaignTag
    {
        $tag = $this->request(
            method: 'get',
            path: 'tags/'.$id,
            responseKey: 'tag'
        );

        return TagFactory::make($tag);
    }

    /**
     * List all tags filtered by name
     *
     * @return Collection<int, ActiveCampaignTag>
     *
     * @throws ActiveCampaignException
     */
    public function list(?string $name = ''): Collection
    {
        $tags = $this->request(
            method: 'get',
            path: 'tags?search='.$name,
            responseKey: 'tags'
        );

        return (new Collection($tags))
            ->map(fn ($tag) => TagFactory::make($tag));
    }

    /**
     * Create a tag and get the id.
     *
     * @param  string  $name
     * @param  string  $description
     * @return string
     *
     * @throws ActiveCampaignException
     */
    public function create(string $name, string $description = ''): string
    {
        $tag = $this->request(
            method: 'post',
            path: 'tags',
            data: ['tag' => [
                'tag' => $name,
                'description' => $description,
                'tagType' => 'contact',
            ]],
            responseKey: 'tag'
        );

        return $tag['id'];
    }

    /**
     * Update an existing tag.
     *
     * @param  ActiveCampaignTag  $tag
     * @return ActiveCampaignTag
     *
     * @throws ActiveCampaignException
     */
    public function update(ActiveCampaignTag $tag): ActiveCampaignTag
    {
        $tag = $this->request(
            method: 'put',
            path: 'tags/'.$tag->id,
            data: ['tag' => [
                'id' => $tag->id,
                'tag' => $tag->name,
                'description' => $tag->description,
            ]],
            responseKey: 'tag'
        );

        return TagFactory::make($tag);
    }

    /**
     * Delete an existing tag by their id.
     *
     * @param  int  $id
     * @return void
     *
     * @throws ActiveCampaignException
     */
    public function delete(int $id): void
    {
        $this->request(
            method: 'delete',
            path: 'tags/'.$id
        );
    }
}
