<?php

namespace WPTL\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

trait HasWordPressService
{
    /**
     * The uri.
     *
     * @var $uri
     */
    protected $uri;

    /**
     * Create an domain of GetPost
     *
     * @return WPTL\Services\WordPress\GetPost
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
     * Get new Guzzle Client
     * @return \GuzzleHttp\Client
     */
    protected function getClient()
    {
        return new Client([
            'base_uri' => $this->domain,
        ]);
    }

    /**
     * Get Guzzle/Request
     * @param  integer $offset
     * @return GuzzleHttp\Psr7\Request
     */
    protected function getRequest($page)
    {
        return new Request('GET', $this->getUri() . '?per_page=100&amp;page=' . $page);
    }

    /**
     * Get Download Request
     * @param  string $path Path to save the downloaded file
     * @return GuzzleHttp\Psr7\Request
     */
    protected function getDownloadRequest($path)
    {
        return $this->getClient()->request('GET', $this->getUri(), [
            'sink' => $path,
        ]);
    }
}
