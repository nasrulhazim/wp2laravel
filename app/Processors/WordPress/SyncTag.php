<?php

namespace WPTL\Processors\WordPress;

use WPTL\Models\Tag;

/**
 * SyncTag Processor
 */
class SyncTag
{
    /**
     * The instance.
     *
     * @var $instance
     */
    protected $instance;

    /**
     * Create a new SyncTag instance.
     *
     * @return void
     */
    public function __construct($instance)
    {
        $this->instance = $instance;
    }

    /**
     * Create an instance of SyncTag
     *
     * @return WPTL\Processors\WordPress\SyncTag
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
        Tag::firstOrCreate([
            'name' => $this->instance->name,
        ]);
    }
}
