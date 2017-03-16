<?php
/** Laravel-PhraseApp-Client
 *
 * (The MIT license)
 * Copyright (c) 2017 andrealeixo.com
 */

namespace Ajaaleixo\PhraseApp;

use Illuminate\Support\ServiceProvider;
use Ajaaleixo\PhraseApp\Commands\UpdateCommand;

class PhraseAppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../resources/config/laravel-phraseapp-client.php' => config_path('laravel-phraseapp.php'),
        ], 'config');

        $this->app['command.phraseapp:update'] = $this->app->make(UpdateCommand::class);

        $this->commands([
            'command.phraseapp:update',
        ]);

    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../resources/config/laravel-phraseapp-client.php', 'laravel-phraseapp');
    }
}