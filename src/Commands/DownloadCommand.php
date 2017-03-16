<?php

namespace Ajaaleixo\PhraseApp\Commands;

use Ajaaleixo\PhraseApp\Client\PhraseAppClient;
use Illuminate\Console\Command;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

class DownloadCommand extends Command
{
    protected $signature = 'phraseapp:download';

    protected $description = 'Updated locale files from PhraseApp';

    protected $config;

    protected $files;

    public function __construct(Repository $config, Filesystem $files)
    {
        parent::__construct();

        $this->config = $config;
        $this->files = $files;
    }

    public function handle()
    {
        // Fetch configs
        $enabled = $this->config->get('laravel-phraseapp.enabled');
        $locales = $this->config->get('laravel-phraseapp.locales');
        $tags = $this->config->get('laravel-phraseapp.tags');
        $seconds = $this->config->get('laravel-phraseapp.api.sleep');

        if (!$enabled) {
            $this->warn('laravel-phraseapp not enabled! Check config!');
            return;
        }

        // Prepare client
        $client = $this->makeClient();

        // Fetch translation per tag per locale
        foreach ($locales as $locale) {
            foreach ($tags as $tag) {

                $this->info(sprintf('Fetching [%s] [tag:%s]', $locale, $tag));

                $content = $client->downloadLocale($locale, $tag);
                $path = $this->makeFilePath($locale, $tag);
                Storage::disk('lang')->put($path, $content);

                $this->info(sprintf('Stored file [%s]', $path));

                sleep($seconds);
            }
        }
    }

    protected function makeFilePath($locale, $tag)
    {
        return sprintf('%s/%s.php', $this->makeLocaleFolder($locale), $tag);
    }

    protected function makeLocaleFolder(string $locale)
    {
        return explode('-', $locale)[0];
    }

    protected function makeClient():PhraseAppClient
    {
        return new PhraseAppClient(
            $this->config->get('laravel-phraseapp.project_id'),
            $this->config->get('laravel-phraseapp.api.key'),
            $this->config->get('laravel-phraseapp.api.uri'),
            $this->config->get('laravel-phraseapp.identification', 'Ajaaleixo Laravel PhraseApp Package (andre.aleixo@olx.com)'),
            $this->config->get('laravel-phraseapp.api.timeout', 5.0),
            $this->config->get('laravel-phraseapp.api.format', 'laravel')
        );
    }
}