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
        $configPath = __DIR__ . '/../config/active-campaign.php';
        $this->publishes([$configPath => $this->getConfigPath()], 'config');
    }

    /**
     * Get the config path
     *
     * @return string
     */
    protected function getConfigPath()
    {
        return config_path('active-campaign.php');
    }

    /**
     * Publish the config file
     *
     * @param string $configPath
     */
    protected function publishConfig($configPath)
    {
        $this->publishes([$configPath => config_path('active-campaign.php')], 'config');
    }
}
