<?php

return [

    /**
     * The URL of your Freshdesk
     */
    'url' => env('FRESHDESK_DOMAIN', 'https://mundotes.freshdesk.com'),

    /**
     * The api key of freshdesk
     */
    'api_key' => env('FRESHDESK_API_KEY', ''),

    'contact_subject' => env('FRESHDESK_CONTACT_SUBJECT', 'Soporte Feria DEV'),

];
