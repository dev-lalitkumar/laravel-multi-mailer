<?php

// config for Adrashyawarrior/LaravelMultiMailer
return [
    'MAILGUN_API_KEY' => env('MAILGUN_API_KEY'),
    'MAILGUN_HOSTNAME' => env('MAILGUN_HOSTNAME', 'smtp.mailgun.org'),
    'MAILGUN_DOMAIN' => env('MAILGUN_DOMAIN'),

    'SENDINBLUE_API_KEY' => env('SENDINBLUE_API_KEY')
];
