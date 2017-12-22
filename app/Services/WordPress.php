<?php

namespace OSI\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

/**
 * WordPress Service
 */
class WordPress
{
    /**
     * The current.
     *
     * @var $current
     */
    protected $current;

    /**
     * The total.
     *
     * @var $total
     */
    protected $total;

    /**
     * The uri.
     *
     * @var $uri
     */
    protected $uri;

    /**
     * Create a new GetPost domain.
     *
     * @return void
     */
    public function __construct($domain)
    {
        $this->domain  = $domain;
        $this->total   = 100;
        $this->current = 0;
    }

    /**
     * Create an domain of GetPost
     *
     * @return OSI\Services\WordPress\GetPost
     */
    public static function make($domain)
    {
        return new self($domain);
    }

    /**
     * Set URI
     * @param string $uri
     * @return $this
     */
    public function setUri(string $uri)
    {
        $this->uri = $uri;
        return $this;
    }

    /**
     * Get URI
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Handle the processing
     *
     * @return void
     */
    public function handle()
    {
        $client = new Client([
            'base_uri' => $this->domain,
        ]);

        $offset = ($this->total - $this->current);

        if ($offset < 0) {
            return false;
        }
        $request = new Request('GET', $this->getUri(), [
            'query' => [
                'per_page' => 100,
                'offset'   => $offset,
            ],
        ]);

        $promise = $client->sendAsync($request)->then(function ($response) {
            $this->total = $response->getHeader('x-wp-total')[0];
            $this->total = ((int) $this->total);
            $this->store($this->uri, $response->getBody());
        });
        $promise->wait();

        if ($this->current < $this->total) {
            $this->current = $this->current + 100;
            $this->handle();
        }
    }

    /**
     * Store in WP storage
     * @param  string $type    Type of Resource
     * @param  json $content
     * @return void
     */
    private function store($type, $content)
    {
        $filename = 'wp/' . $type . '_' . \Carbon\Carbon::now()->format('YmdHis') . '.json';
        file_put_contents(storage_path($filename), $this->json_pretty($content));
    }

    /**
     * Format to JSON Pretty
     * @param  json $data JSON Encoded
     * @return json       JSON Pretty Encoded
     */
    private function json_pretty($data)
    {
        $data = json_decode($data);
        return json_encode($data, JSON_PRETTY_PRINT);
    }
}
