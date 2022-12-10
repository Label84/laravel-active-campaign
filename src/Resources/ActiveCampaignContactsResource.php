<?php

namespace Label84\ActiveCampaign\Resources;

use Illuminate\Support\Collection;
use Label84\ActiveCampaign\ActiveCampaignService;
use Label84\ActiveCampaign\DataObjects\ActiveCampaignContact;
use Label84\ActiveCampaign\Exceptions\ActiveCampaignException;
use Label84\ActiveCampaign\Factories\ContactFactory;

class ActiveCampaignContactsResource extends ActiveCampaignBaseResource
{

    /**
     * Retreive an existing contact by their id.
     *
     * @param  int  $id
     * @return ActiveCampaignContact
     */
    public function get(int $id): ActiveCampaignContact
    {
        $contact = $this->request(
            method: 'get',
            path: 'contacts/'.$id,
            responseKey: 'contact'
        );

        return ContactFactory::make($contact);
    }

    /**
     * List all contact, search contacts, or filter contacts by query defined criteria.
     *
     * @return Collection<int, ActiveCampaignContact>
     */
    public function list(?string $query = ''): Collection
    {

        $contacts = $this->request(
            method: 'get',
            path: 'contacts?'.$query,
            responseKey: 'contacts'
        );

        return collect($contacts)
            ->map(fn ($contact) => ContactFactory::make($contact));
    }

    /**
     * Create a contact and get the contact id.
     *
     * @param string $email
     * @param array $attributes
     * @return string
     * @throws ActiveCampaignException
     */
    public function create(string $email, array $attributes = []): string
    {
        $contact = $this->request(
            method: 'post',
            path: 'contacts',
            data: ['contact' => [
                    'email' => $email,
                ] + $attributes

            ],
            responseKey: 'contact'
        );

        return $contact['id'];
    }

    /**
     * Update an existing contact.
     *
     * @param ActiveCampaignContact $contact
     * @return ActiveCampaignContact
     * @throws ActiveCampaignException
     */
    public function update(ActiveCampaignContact $contact): ActiveCampaignContact
    {
        $contact = $this->request(
            method: 'put',
            path: 'contacts/'.$contact->id,
            data: ['contact' => [
                    'email' => $contact->email,
                    'firstName' => $contact->firstName,
                    'lastName' => $contact->lastName,
                    'phone' => $contact->phone,
                ]
            ],
            responseKey: 'contact'
        );

        return ContactFactory::make($contact);
    }

    /**
     * Delete an existing contact by their id.
     *
     * @param int $id
     * @return void
     * @throws ActiveCampaignException
     */
    public function delete(int $id): void
    {
        $this->request(
            method: 'delete',
            path: 'contacts/'.$id
        );
    }
}
