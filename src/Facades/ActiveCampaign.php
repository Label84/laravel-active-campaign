<?php

namespace Label84\ActiveCampaign\Facades;

use Illuminate\Support\Facades\Facade;

class ActiveCampaign extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'active-campaign';
    }
}
