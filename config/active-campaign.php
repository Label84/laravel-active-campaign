<?php

return [

    /**
     * Your Active Campaign Base URL
     * https://<your-account>.api-us1.com/api/3
     * 
     * More information: https://developers.activecampaign.com/reference/url
     */
    'base_url' => env('ACTIVE_CAMPAIGN_BASE_URL'),

    /**
     * Your Active Campaign API key
     * 
     * Your API key can be found in your account on the Settings page under the "Developer" tab. 
     * Each user in your ActiveCampaign account has their own unique API key.
     */
    'api_key' => env('ACTIVE_CAMPAIGN_API_KEY'),

    'timeout' => 100,

    'retry_times' => 3,

    'retry_sleep' => 5,

    /**
     * (optional)
     * Here you can list your custom fields ids.
     */
    'custom_fields' => [
        // 'is_email_verified' => 50,
    ],

];
