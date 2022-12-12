<?php

namespace Label84\ActiveCampaign\Factories;

use Label84\ActiveCampaign\DataObjects\ActiveCampaignContact;

class ContactFactory
{
    /**
     * @param  array<string>  $attributes
     * @return ActiveCampaignContact
     */
    public static function make(array $attributes): ActiveCampaignContact
    {
        return new ActiveCampaignContact(
            intval($attributes['id']),
            $attributes['email'],
            $attributes['phone'],
            $attributes['firstName'],
            $attributes['lastName'],
        );
    }
}
