<?php

namespace Ajaaleixo\PhraseApp;

use Illuminate\Support\ServiceProvider;
use Ajaaleixo\PhraseApp\Commands\DownloadCommand;

class PhraseAppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../resources/config/laravel-phraseapp-client.php' => config_path('laravel-phraseapp.php'),
        ], 'config');

        $this->app['command.phraseapp:download'] = $this->app->make(DownloadCommand::class);

        $this->commands([
            'command.phraseapp:download',
        ]);
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../resources/config/laravel-phraseapp-client.php', 'laravel-phraseapp');
    }
}