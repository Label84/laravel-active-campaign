<?php

namespace Label84\ActiveCampaign\DataObjects;

class ActiveCampaignField
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly string $description,
        public readonly string $type,
        public readonly string $isRequired,
        public readonly string $perstag,
        public readonly string $defaultValue,
        public readonly ?string $showInList,
        public readonly ?string $rows,
        public readonly ?string $cols,
        public readonly string $visible,
        public readonly ?string $service,
        public readonly string $orderNumber,
        public readonly ?string $createdDate,
        public readonly ?string $updatedDate,
        public readonly ?array $options,
        public readonly ?array $relations,
        public readonly ?array $links,
    ) {
    }
}
