<?php

namespace Tests;

use Ajaaleixo\PhraseApp\Client\PhraseAppClient;
use Ajaaleixo\PhraseApp\PhraseAppServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            PhraseAppServiceProvider::class,
        ];
    }

    protected function makeMockFetchLocales()
    {
        $client = \Mockery::mock(PhraseAppClient::class);
        $client
            ->shouldReceive('getLocales')
            ->andReturn($this->makeMockLocalesList());

        return $client;
    }

    protected function makeMockLocalesList()
    {
        return [
            [
                "id" => "abcd1234cdef1234abcd1234cdef1234",
                "name" => "de",
                "code" => "de-DE",
                "default" => true,
                "main" => false,
                "rtl" => false,
                "plural_forms" => [
                    "zero",
                    "one",
                    "other"
                ],
                "source_locale" => [
                    "id" => "abcd1234cdef1234abcd1234cdef1234",
                    "name" => "en",
                    "code" => "en-GB"
                ],
                "created_at" => "2015-01-28T09:52:53Z",
                "updated_at" => "2015-01-28T09:52:53Z",
            ]
        ];
    }
}