<?php

namespace Adrashyawarrior\LaravelMultiMailer\Commands;

use Illuminate\Console\Command;

class LaravelMultiMailerCommand extends Command
{
    public $signature = 'laravel-multi-mailer';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
