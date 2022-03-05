<?php

namespace Label84\ActiveCampaign;

use Illuminate\Support\ServiceProvider;

class ActiveCampaignServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ActiveCampaign::class, function () {
            return new ActiveCampaignService(
                config('active-campaign.base_url'),
                config('active-campaign.api_key'),
                config('active-campaign.timeout'),
                config('active-campaign.retry_times'),
                config('active-campaign.retry_sleep'),
            );
        });
    }

    public function boot(): void
    {
        //
    }
}
