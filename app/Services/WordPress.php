<?php

namespace WPTL\Services;

use WPTL\Traits\HasWordPressService;

/**
 * WordPress Service
 */
class WordPress
{
    use HasWordPressService;

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
     * Handle the processing
     *
     * @return void
     */
    public function handle()
    {
        $client = $this->getClient();

        $offset = ($this->total - $this->current);

        if ($offset < 0) {
            return false;
        }

        $request = $this->getRequest();

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
    public function store($type, $content)
    {
        $filename = 'wp/' . $type . '_' . \Carbon\Carbon::now()->format('YmdHis') . '.json';
        file_put_contents(storage_path($filename), $this->json_pretty($content));
    }

    /**
     * Format to JSON Pretty
     * @param  json $data JSON Encoded
     * @return json       JSON Pretty Encoded
     */
    public function json_pretty($data)
    {
        $data = json_decode($data);
        return json_encode($data, JSON_PRETTY_PRINT);
    }
}
