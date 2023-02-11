# AdrashyaWarrior Laravel Multi-Mailer

AdrashyaWarrior Laravel Multi-Mailer is a package built on top of mailgun, sendinblue & sendgrid email providers.

## STEP(1): Installation

Go to your project's root directory and run

```bash
composer require adrashyawarrior/laravel-multi-mailer
```

## STEP(2): Update .env
Add the following environment varables
```env
# priority
MAILERS=sendgrid,mailgun,sendinblue
# Mailgun
MAILGUN_API_KEY=''
MAILGUN_HOSTNAME=''
MAILGUN_DOMAIN=''
# Sendinblue
SENDINBLUE_API_KEY=''
# Sendgrid
SENDGRID_API_KEY=''
```

## STEP(3): Usage
Inside your controller

```php
<?php

namespace App\Http\Controllers;

use Adrashyawarrior\LaravelMultiMailer\LaravelMultiMailer;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function sendmail()
    {
        try {
            $mailer = new LaravelMultiMailer();
            $mailer->from('shiva@gmail.com', 'Shaiva Sh');
            $mailer->to(['krishna@gmail.com']);
            $mailer->cc(['radha@gmail.com']);
            $mailer->bcc(['sudama@gmail.com']);
            $mailer->subject('Testing New Package');
            $mailer->html('<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Document</title>
            </head>
            <body>
                <h1>This is a testing mail.</h1>
            </body>
            </html>');
            $response = $mailer->send();
            return response()->json($response);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return response('Error');
        }
    }
}

```

## Congrats! Done.
You are all set to send emails.

## Contributing

Pull requests are welcome. For major changes, please open an issue first
to discuss what you would like to change.

## License

[MIT](https://choosealicense.com/licenses/mit/)

