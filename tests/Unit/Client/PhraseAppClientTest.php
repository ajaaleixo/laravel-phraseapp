<?php

namespace Tests\Unit\Client;

use Ajaaleixo\PhraseApp\Client\PhraseAppClient;
use Tests\TestCase;

class PhraseAppClientTest extends TestCase
{
    public function testCanFetchLocales()
    {
        $client = $this->makeMockFetchLocales();
        $localesExpectedList = $this->makeMockLocalesList();

        $result = $client->getLocales();

        $this->assertEquals($localesExpectedList, $result);
    }
    
    public function testClientCanBeInitializedWithoutIdentificationAndTimeout()
    {
        $projectId = 'xpto';
        $apiKey = 'theKey';
        $apiBaseUri = 'https://example.com/api/v2';

        $client = new PhraseAppClient($projectId, $apiKey, $apiBaseUri);

        $this->assertInstanceOf(PhraseAppClient::class, $client);
        $this->assertEquals($projectId, $client->getProject());
        $this->assertEquals('laravel', $client->getFormat());
        $this->assertEquals($this->getDefaultHeadersAfterConstructorWithKey($apiKey), $client->getHeaders());
    }

    public function testClientCanBeInitializedWithAllParameters()
    {
        $projectId = 'xpto';
        $apiKey = 'theKey';
        $apiBaseUri = 'https://example.com/api/v2';
        $identification = 'the tester (tester@tester.com)';
        $timeout = 6.0;
        $format = 'theFormat';

        $client = new PhraseAppClient($projectId, $apiKey, $apiBaseUri, $identification, $timeout, $format);

        $headers = [
            'User-Agent' => $identification,
            'Authorization' => sprintf('token %s', $apiKey),
        ];

        $this->assertInstanceOf(PhraseAppClient::class, $client);
        $this->assertEquals($format, $client->getFormat());
        $this->assertEquals($headers, $client->getHeaders());
        $this->assertEquals($timeout, $client->getTimeout());
        $this->assertEquals($projectId, $client->getProject());
    }

    public function testCanSetHeadersFluently()
    {
        $projectId = 'xpto';
        $apiKey = 'theKey';
        $apiBaseUri = 'https://example.com/api/v2';
        $client = new PhraseAppClient($projectId, $apiKey, $apiBaseUri);
        $result = $client->withHeader('theHeader', 'theHeaderValue');

        $expectedHeaders = $this->getDefaultHeadersAfterConstructorWithKey($apiKey);
        $expectedHeaders['theHeader'] = 'theHeaderValue';

        $this->assertInstanceOf(PhraseAppClient::class, $result);
        $this->assertEquals($expectedHeaders, $client->getHeaders());
    }

    protected function getDefaultHeadersAfterConstructorWithKey($apiKey)
    {
        return [
            'User-Agent' => 'Ajaaleixo Laravel PhraseApp Package (andre.aleixo@olx.com)',
            'Authorization' => sprintf('token %s', $apiKey),
        ];
    }
}