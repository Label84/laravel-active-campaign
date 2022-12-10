<?php

namespace Label84\ActiveCampaign\Resources;

use Illuminate\Support\Collection;
use Label84\ActiveCampaign\ActiveCampaignService;
use Label84\ActiveCampaign\DataObjects\ActiveCampaignTag;
use Label84\ActiveCampaign\Exceptions\ActiveCampaignException;
use Label84\ActiveCampaign\Factories\TagFactory;

class ActiveCampaignTagsResource
{
    public function __construct(
        private ActiveCampaignService $service,
    ) {
    }

    /**
     * Retreive an existing tag by their id.
     *
     * @param  int  $id
     * @return ActiveCampaignTag
     */
    public function get(int $id): ActiveCampaignTag
    {
        $request = $this->service->makeRequest();

        $response = $request->get("/tags/{$id}");

        if ($response->failed()) {
            throw new ActiveCampaignException($response->json());
        }

        $tag = json_decode($response->body(), true)['tag'];

        return TagFactory::make($tag);
    }

    /**
     * List all tags filtered by name
     *
     * @return Collection<int, ActiveCampaignTag>
     */
    public function list(?string $name = ''): Collection
    {
        $request = $this->service->makeRequest();

        $response = $request->get("tags?search={$name}");

        if ($response->failed()) {
            throw new ActiveCampaignException($response->json());
        }

        $tags = json_decode($response->body(), true)['tags'];

        return (new Collection($tags))
            ->map(fn ($tag) => TagFactory::make($tag));
    }

    /**
     * Create a tag and get the id.
     *
     * @param  string  $name
     * @param  string  $description
     * @return string
     */
    public function create(string $name, string $description = ''): string
    {
        $request = $this->service->makeRequest();

        $response = $request->post('/tags', ['tag' => [
            'tag' => $name,
            'description' => $description,
            'tagType' => 'contact',
        ]]);

        if ($response->failed()) {
            throw new ActiveCampaignException($response->json());
        }

        $tag = json_decode($response->body(), true)['tag'];

        return $tag['id'];
    }

    /**
     * Update an existing tag.
     *
     * @param  ActiveCampaignTag  $tag
     * @return ActiveCampaignTag
     */
    public function update(ActiveCampaignTag $tag): ActiveCampaignTag
    {
        $request = $this->service->makeRequest();

        $response = $request->put("/tags/{$tag->id}", ['tag' => [
            'id' => $tag->id,
            'tag' => $tag->name,
            'description' => $tag->description,
        ]]);

        if ($response->failed()) {
            throw new ActiveCampaignException($response->json());
        }

        $tag = json_decode($response->body(), true)['tag'];

        return TagFactory::make($tag);
    }

    /**
     * Delete an existing tag by their id.
     *
     * @param  int  $id
     * @return int
     */
    public function delete(int $id): int
    {
        $request = $this->service->makeRequest();

        $response = $request->delete("/tags/{$id}");

        if ($response->failed()) {
            throw new ActiveCampaignException($response->json());
        }

        return $response->status();
    }
}
