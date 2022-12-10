<?php

namespace Label84\ActiveCampaign\Resources;

use Illuminate\Support\Collection;
use Label84\ActiveCampaign\ActiveCampaignService;
use Label84\ActiveCampaign\DataObjects\ActiveCampaignContact;
use Label84\ActiveCampaign\Exceptions\ActiveCampaignException;
use Label84\ActiveCampaign\Factories\ContactFactory;

class ActiveCampaignContactsResource
{
    public function __construct(
        private ActiveCampaignService $service,
    ) {
    }

    /**
     * Retreive an existing contact by their id.
     *
     * @param  int  $id
     * @return ActiveCampaignContact
     */
    public function get(int $id): ActiveCampaignContact
    {
        $request = $this->service->makeRequest();

        $response = $request->get("/contacts/{$id}");

        if ($response->failed()) {
            throw new ActiveCampaignException($response->json());
        }

        $contact = json_decode($response->body(), true)['contact'];

        return ContactFactory::make($contact);
    }

    /**
     * List all contact, search contacts, or filter contacts by query defined criteria.
     *
     * @return Collection<int, ActiveCampaignContact>
     */
    public function list(?string $query = ''): Collection
    {
        $request = $this->service->makeRequest();

        $response = $request->get("contacts?{$query}");

        if ($response->failed()) {
            throw new ActiveCampaignException($response->json());
        }

        $contacts = json_decode($response->body(), true)['contacts'];

        return (new Collection($contacts))
            ->map(fn ($contact) => ContactFactory::make($contact));
    }

    /**
     * Create a contact and get the contact id.
     *
     * @param  string  $email
     * @param  array  $attributes
     * @return string
     */
    public function create(string $email, array $attributes = []): string
    {
        $request = $this->service->makeRequest();

        $response = $request->post('/contacts', ['contact' => [
            'email' => $email,
        ] + $attributes]);

        if ($response->failed()) {
            throw new ActiveCampaignException($response->json());
        }

        $contact = json_decode($response->body(), true)['contact'];

        return $contact['id'];
    }

    /**
     * Update an existing contact.
     *
     * @param  ActiveCampaignContact  $contact
     * @return ActiveCampaignContact
     */
    public function update(ActiveCampaignContact $contact): ActiveCampaignContact
    {
        $request = $this->service->makeRequest();

        $response = $request->put("/contacts/{$contact->id}", ['contact' => [
            'email' => $contact->email,
            'firstName' => $contact->firstName,
            'lastName' => $contact->lastName,
            'phone' => $contact->phone,
        ]]);

        if ($response->failed()) {
            throw new ActiveCampaignException($response->json());
        }

        $contact = json_decode($response->body(), true)['contact'];

        return ContactFactory::make($contact);
    }

    /**
     * Delete an existing contact by their id.
     *
     * @param  int  $id
     * @return int
     */
    public function delete(int $id): int
    {
        $request = $this->service->makeRequest();

        $response = $request->delete("/contacts/{$id}");

        if ($response->failed()) {
            throw new ActiveCampaignException($response->json());
        }

        return $response->status();
    }
}
