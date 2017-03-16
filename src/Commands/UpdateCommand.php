<?php

namespace Ajaaleixo\PhraseApp\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Config\Repository;

class UpdateCommand extends Command
{
    protected $signature = 'phraseapp:update';

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
        // void
    }
}