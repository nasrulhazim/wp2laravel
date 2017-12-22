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
     * The total_pages.
     *
     * @var $total_pages
     */
    protected $total_pages;

    /**
     * Create a new GetPost domain.
     *
     * @return void
     */
    public function __construct($domain)
    {
        $this->domain  = $domain;
        $this->current = 1;
    }

    /**
     * Handle the processing
     *
     * @return void
     */
    public function handle()
    {
        $message = $this->getUri() . ' page - ' . $this->current;
        echo title_case($message) . PHP_EOL;

        if ($this->current % 5 == 0) {
            sleep(3); // sleep
        }

        $client  = $this->getClient();
        $request = $this->getRequest($this->current);
        $promise = $client->sendAsync($request)->then(function ($response) {
            $this->total_pages = $response->getHeader('X-WP-TotalPages')[0];
            $this->total_pages = ((int) $this->total_pages);
            $this->store($this->uri, $response->getBody());
        }, function ($exception) {
            logger()->error($exception->getMessage());
        });
        $promise->wait();
        if ($this->current <= $this->total_pages) {
            $this->current = $this->current + 1;
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
