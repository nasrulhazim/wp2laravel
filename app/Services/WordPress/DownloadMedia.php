<?php

namespace WPTL\Services\WordPress;

use NasrulHazim\Contracts\ServiceContract;

/**
 * DownloadMedia Service
 */
class DownloadMedia implements ServiceContract
{
    /**
     * The instance.
     *
     * @var $instance 
     */
    protected $instance;

    /**
     * Create a new DownloadMedia instance.
     *
     * @return void
     */
    public function __construct($instance)
    {
        $this->instance = $instance;
    }

	/**
	 * Create an instance of DownloadMedia
     *
	 * @return WPTL\Services\WordPress\DownloadMedia 
	 */
    public static function make($instance)
    {
    	return new self($instance);
    }

    /**
     * Handle the processing
     *
     * @return void
     */
    public function handle()
    {

    }
}
