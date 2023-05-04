<?php

namespace Label84\ActiveCampaign\Resources;

use Illuminate\Support\Collection;
use Label84\ActiveCampaign\DataObjects\ActiveCampaignContact;
use Label84\ActiveCampaign\Exceptions\ActiveCampaignException;
use Label84\ActiveCampaign\Factories\ContactFactory;

class ActiveCampaignContactsResource extends ActiveCampaignBaseResource
{
    /**
     * Retreive an existing contact by their id.
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
     *
     * @throws ActiveCampaignException
     */
    public function create(string $email, array $attributes = []): string
    {
        $contact = $this->request(
            method: 'post',
            path: 'contacts',
            data: [
                'contact' => [
                    'email' => $email,
                ] + $attributes,
            ],
            responseKey: 'contact'
        );

        return $contact['id'];
    }

    /**
     * Update an existing contact.
     *
     *
     * @throws ActiveCampaignException
     */
    public function update(ActiveCampaignContact $contact): ActiveCampaignContact
    {
        $contact = $this->request(
            method: 'put',
            path: 'contacts/'.$contact->id,
            data: [
                'contact' => [
                    'email' => $contact->email,
                    'firstName' => $contact->firstName,
                    'lastName' => $contact->lastName,
                    'phone' => $contact->phone,
                ],
            ],
            responseKey: 'contact'
        );

        return ContactFactory::make($contact);
    }

    /**
     * Create a contact or update an existing contact and return the ID.
     *
     * @see https://developers.activecampaign.com/reference/sync-a-contacts-data
     *
     * @throws ActiveCampaignException
     */
    public function sync(string $email, array $attributes = []): ActiveCampaignContact
    {
        return ContactFactory::make($this->request(
            method: 'post',
            path: 'contact/sync',
            data: [
                'contact' => [
                    'email' => $email,
                ] + $attributes,
            ],
            responseKey: 'contact'
        ));
    }

    /**
     * Subscribe a contact to a list or unsubscribe a contact from a list.
     *
     * @see https://developers.activecampaign.com/reference/update-list-status-for-contact
     *
     * @throws ActiveCampaignException
     */
    public function updateListStatus(int $contactId, int $listId, int $status): ActiveCampaignContact
    {
        return ContactFactory::make($this->request(
            method: 'post',
            path: 'contact/sync',
            data: [
                'contactList' => [
                    'list' => $listId,
                    'contact' => $contactId,
                    'status' => $status,
                ],
            ],
            responseKey: 'contact'
        ));
    }

    /**
     * Delete an existing contact by their id.
     *
     *
     * @throws ActiveCampaignException
     */
    public function delete(int $id): void
    {
        $this->request(
            method: 'delete',
            path: 'contacts/'.$id
        );
    }

    /**
     * Add a tag to a contact.
     *
     * @see https://developers.activecampaign.com/reference/create-contact-tag
     *
     * @throws ActiveCampaignException
     */
    public function tag(int $id, int $tagId): string
    {
        $contactTag = $this->request(
            method: 'post',
            path: 'contactTags',
            data: [
                'contactTag' => [
                    'contact' => $id,
                    'tag' => $tagId,
                ],
            ],
            responseKey: 'contactTag'
        );

        return $contactTag['id'];
    }

    /**
     * Remove a tag from a contact.
     *
     * @see https://developers.activecampaign.com/reference#delete-contact-tag
     *
     * @throws ActiveCampaignException
     */
    public function untag(int $contactTagId): void
    {
        $this->request(
            method: 'delete',
            path: 'contactTags/'.$contactTagId
        );
    }
}
