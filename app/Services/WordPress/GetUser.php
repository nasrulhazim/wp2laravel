<?php

namespace WPTL\Services\WordPress;

use WPTL\Services\WordPress as WP;

/**
 * GetUser Service
 */
class GetUser extends WP
{
    /**
     * The instance.
     *
     * @var $instance
     */
    protected $users;

    /**
     * Handle the processing
     *
     * @return void
     */
    public function handle()
    {
        $client  = new \GuzzleHttp\Client();
        $request = new \GuzzleHttp\Psr7\Request('GET', $domain . 'posts');
        $promise = $client->sendAsync($request)->then(function ($response) {
            $this->total    = $response->getHeader('x-wp-total');
            $this->response = $response->getBody();
        });
        $promise->wait();
    }
}
