<?php

namespace Adrashyawarrior\LaravelMultiMailer\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Adrashyawarrior\LaravelMultiMailer\LaravelMultiMailer
 */
class LaravelMultiMailer extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Adrashyawarrior\LaravelMultiMailer\LaravelMultiMailer::class;
    }
}
