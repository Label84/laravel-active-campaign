<?php

namespace Label84\ActiveCampaign\DataObjects;

class ActiveCampaignContact
{
    public function __construct(
        public readonly int $id,
        public readonly string $email,
        public readonly ?string $phone,
        public readonly ?string $firstName,
        public readonly ?string $lastName,
    ) {
    }
}
