<?php

namespace Label84\ActiveCampaign\Resources;

use Illuminate\Support\Collection;
use Label84\ActiveCampaign\DataObjects\ActiveCampaignContact;
use Label84\ActiveCampaign\Exceptions\ActiveCampaignException;
use Label84\ActiveCampaign\Factories\ContactFactory;

class ActiveCampaignContactsResource extends ActiveCampaignBaseResource
{
    /**
     * Retrieve an existing contact by their ID.
     *
     * @see https://developers.activecampaign.com/reference/get-contact
     *
     * @throws ActiveCampaignException
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
     * List all contacts, search contacts, or filter contacts by query defined criteria.
     *
     * @see https://developers.activecampaign.com/reference/list-all-contacts
     *
     * @return Collection<int, ActiveCampaignContact>
     *
     * @throws ActiveCampaignException
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
     * Create a contact and return the contact ID.
     *
     * @see https://developers.activecampaign.com/reference/create-a-new-contact
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
     * @see https://developers.activecampaign.com/reference/update-a-contact-new
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
     * Delete an existing contact by their ID.
     *
     * @see https://developers.activecampaign.com/reference/delete-contact
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
     * @see https://developers.activecampaign.com/reference/remove-a-contacts-tag
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
