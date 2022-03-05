<?php

namespace Label84\ActiveCampaign\Factories;

use Label84\ActiveCampaign\DataObjects\ActiveCampaignTag;

class TagFactory
{
    /**
     * @param array<string> $attributes
     * @return ActiveCampaignTag
     */
    public static function make(array $attributes): ActiveCampaignTag
    {
        return new ActiveCampaignTag(
            intval($attributes['id']),
            $attributes['tag'],
            $attributes['description'],
        );
    }
}
