<?php

namespace Label84\ActiveCampaign;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class ActiveCampaignServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register(): void
    {
        $this->app->singleton(ActiveCampaign::class, function () {
            return new ActiveCampaign(
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
        $configPath = __DIR__.'/../config/active-campaign.php';
        $this->publishes([$configPath => $this->getConfigPath()], 'config');
    }

    protected function getConfigPath(): string
    {
        return config_path('active-campaign.php');
    }

    /**
     * Defer provision of ActiveCampaign service until needed
     *
     * @return array<int, string>
     */
    public function provides(): array
    {
        return [ActiveCampaign::class];
    }
}
