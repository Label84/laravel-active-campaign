<?php

namespace Label84\ActiveCampaign\DataObjects;

class ActiveCampaignList
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $stringid,
        public readonly string $sender_url,
        public readonly string $sender_reminder,
        public readonly ?string $send_last_broadcast,
        public readonly ?string $carboncopy,
        public readonly ?string $subscription_notify,
        public readonly ?string $unsubscription_notify,
        public readonly ?int $user,
    ) {
    }
}
