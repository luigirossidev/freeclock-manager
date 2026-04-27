<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Admin's email domain
    |--------------------------------------------------------------------------
    |
    | Used for Filament's admin panel
    | Necessary in prod to log in
    |
    |
    */

    'admin_email_domain' => env('ADMIN_EMAIL_DOMAIN'),

    /*
    |--------------------------------------------------------------------------
    | Project URL
    |--------------------------------------------------------------------------
    |
    | URL shown on the public dashboard (GitHub button).
    |
    */

    'project_url' => env('PROJECT_URL', 'https://github.com/Matese-Makers/FreeClock'),

];
