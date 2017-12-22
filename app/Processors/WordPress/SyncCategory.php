<?php

namespace WPTL\Processors\WordPress;

use WPTL\Models\Category;

/**
 * SyncCategory Processor
 */
class SyncCategory
{
    /**
     * The instance.
     *
     * @var $instance
     */
    protected $instance;

    /**
     * Create a new SyncCategory instance.
     *
     * @return void
     */
    public function __construct($instance)
    {
        $this->instance = $instance;
    }

    /**
     * Create an instance of SyncCategory
     *
     * @return WPTL\Processors\WordPress\SyncCategory
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
        Category::firstOrCreate([
            'name' => $this->instance->name,
        ]);
    }
}
