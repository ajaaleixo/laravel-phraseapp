<?php

namespace Ajaaleixo\PhraseApp\Client;

use Ajaaleixo\PhraseApp\Exceptions\PhraseAppRequestException;
use GuzzleHttp\Client;

class PhraseAppClient
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var array
     */
    protected $headers = [];

    /**
     * @var string
     */
    protected $identification;

    /**
     * @var float
     */
    protected $timeout;

    /**
     * @var string
     */
    protected $format;

    /**
     * @var string
     */
    protected $project;

    public function __construct(
        string $projectId,
        string $apiKey,
        string $apiBaseUri,
        string $identification = 'Ajaaleixo Laravel PhraseApp Package (andre.aleixo@olx.com)',
        float $timeout = 5.0,
        string $format = 'laravel'
    ) {
        $this->withProject($projectId);
        $this->withAuthorization($apiKey);
        $this->withIdentification($identification);
        $this->withTimeout($timeout);
        $this->withFormat($format);

        $this->client = new Client([
            'base_uri' => $apiBaseUri,
            'timeout' => $this->getTimeout(),
            'headers' => $this->getHeaders(),
        ]);

        return $this;
    }

    public function getHeaders():array
    {
        return $this->headers;
    }

    protected function withIdentification($identification)
    {
        return $this->withHeader('User-Agent', $identification);
    }

    protected function withAuthorization($apiKey)
    {
        return $this->withHeader('Authorization', sprintf('token %s', $apiKey));
    }

    public function withProject(string $projectId)
    {
        $this->project = $projectId;

        return $this;
    }

    public function withHeader($header, $value)
    {
        $this->headers[$header] = $value;

        return $this;
    }

    public function withTimeout(float $timeout)
    {
        $this->timeout = $timeout;

        return $this;
    }

    public function withFormat(string $format)
    {
        $this->format = $format;

        return $this;
    }

    public function getTimeout()
    {
        return $this->timeout;
    }

    public function getFormat()
    {
        return $this->format;
    }

    public function getProject()
    {
        return $this->project;
    }

    /**
     * @return \Psr\Http\Message\StreamInterface
     *
     * @throws PhraseAppRequestException
     */
    public function getLocales()
    {
        $response = $this->client->request(
            'GET',
            sprintf('projects/%s/locales', $this->getProject())
        );

        switch ($response->getStatusCode()) {
            case 200:
                return $response->getBody();
            default:
                throw new PhraseAppRequestException($response->getBody(), $response->getStatusCode());
        }
    }

    public function downloadLocale(string $locale, string $tag)
    {
        $params = [
            'form_params' => [
                'file_format' => $this->getFormat(),
                'tag' => $tag,
            ],
        ];

        $response = $this->client->request(
            'GET',
            sprintf('projects/%s/locales/%s/download', $this->getProject(), $locale),
            $params
        );

        switch ($response->getStatusCode()) {
            case 200:
                return $response->getBody();
            default:
                throw new PhraseAppRequestException($response->getBody(), $response->getStatusCode());
        }
    }
}
