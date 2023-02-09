<?php

namespace Adrashyawarrior\LaravelMultiMailer;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Adrashyawarrior\LaravelMultiMailer\Commands\LaravelMultiMailerCommand;

class LaravelMultiMailerServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-multi-mailer')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-multi-mailer_table')
            ->hasCommand(LaravelMultiMailerCommand::class);
    }
}
