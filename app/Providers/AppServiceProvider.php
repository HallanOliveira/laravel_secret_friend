<?php

namespace App\Providers;

use App\Adapters\Providers\EmailLaravel;
use App\Core\Contracts\EmailProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EmailProvider::class, function($app, $params = []) {
            return new EmailLaravel($params['mailable']);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
