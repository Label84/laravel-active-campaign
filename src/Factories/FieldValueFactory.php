<?php

namespace Label84\ActiveCampaign\Factories;

use Label84\ActiveCampaign\DataObjects\ActiveCampaignFieldValue;

class FieldValueFactory
{
    /**
     * @param  array<string>  $attributes
     */
    public static function make(array $attributes): ActiveCampaignFieldValue
    {
        return new ActiveCampaignFieldValue(
            intval($attributes['id']),
            $attributes['field'],
            $attributes['value'],
        );
    }
}
