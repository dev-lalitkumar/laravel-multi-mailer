<?php

// config for Adrashyawarrior/LaravelMultiMailer
return [
    'MAILERS' => explode(',', env('MAILERS', '')),
    
    'MAILGUN_API_KEY' => env('MAILGUN_API_KEY'),
    'MAILGUN_HOSTNAME' => env('MAILGUN_HOSTNAME', 'smtp.mailgun.org'),
    'MAILGUN_DOMAIN' => env('MAILGUN_DOMAIN'),

    'SENDINBLUE_API_KEY' => env('SENDINBLUE_API_KEY'),

    'SENDGRID_API_KEY' => env('SENDGRID_API_KEY')
];
