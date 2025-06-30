<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\SendGridService;
use App\Channels\SendGridChannel;

class SendGridServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(SendGridService::class, function ($app) {
            return new SendGridService();
        });

        $this->app->singleton(SendGridChannel::class, function ($app) {
            return new SendGridChannel($app->make(SendGridService::class));
        });
    }

    public function boot()
    {
        //
    }
}