<?php

namespace Label84\ActiveCampaign\DataObjects;

class ActiveCampaignFieldValue
{
    public function __construct(
        public readonly int $contactId,
        public readonly string $field,
        public readonly string $value,       
    ) {}
}
