<?php

namespace WPTL\Processors\WordPress;

use WPTL\Models\Post;

/**
 * SyncPost Processor
 */
class SyncPost
{
    /**
     * The instance.
     *
     * @var $instance
     */
    protected $instance;

    /**
     * Create a new SyncPost instance.
     *
     * @return void
     */
    public function __construct($instance)
    {
        $this->instance = $instance;
    }

    /**
     * Create an instance of SyncPost
     *
     * @return WPTL\Processors\WordPress\SyncPost
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
        Post::create([
            'user_id' => 1,
            'title'   => html_entity_decode($this->instance->title->rendered),
            'content' => html_entity_decode($this->instance->content->rendered),
            'old_url' => $this->instance->link,
        ]);
    }
}
