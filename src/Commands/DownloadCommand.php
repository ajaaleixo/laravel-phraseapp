<?php

namespace Ajaaleixo\PhraseApp\Commands;

use Ajaaleixo\PhraseApp\Client\PhraseAppClient;
use Ajaaleixo\PhraseApp\Utils\LocaleFileWriter;
use Illuminate\Console\Command;
use Illuminate\Contracts\Config\Repository;

class DownloadCommand extends Command
{
    protected $signature = 'phraseapp:download';

    protected $description = 'Updated locale files from PhraseApp';

    protected $config;

    /**
     * UpdateCommand constructor.
     *
     * @param Repository $config
     */
    public function __construct(Repository $config)
    {
        parent::__construct();

        $this->config = $config;
    }

    public function handle()
    {
        // Fetch configs
        $enabled = $this->config->get('laravel-phraseapp.enabled');
        $locales = $this->config->get('laravel-phraseapp.locales');
        $tags = $this->config->get('laravel-phraseapp.tag');
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
                // Use tag as the file to put the content in
                $this->info(sprintf('Fetching [%s] [tag:%s]..', $locale, $tag));
                $content = $client->downloadLocale($locale, $tag);
                $bytes = LocaleFileWriter::write($content, $locale, $tag);
                $this->info(sprintf('  Fetched %s bytes', $bytes));
                sleep($seconds);
            }
        }
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