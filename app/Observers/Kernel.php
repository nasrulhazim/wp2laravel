<?php

namespace WPTL\Observers;

/**
 *
 */
class Kernel
{
    /**
     * Single one-on-one observer
     * @var array
     */
    protected $observers = [
        // FQCN of Model => FQCN of Observer
    ];

    /**
     * One observer observed by many models
     * @var array
     */
    protected $observeBy = [
        \WPTL\Observers\ReferenceObserver::class => [

        ],
        \WPTL\Observers\HashidsObserver::class   => [
            \WPTL\Models\User::class,
            \WPTL\Models\Post::class,
            \Spatie\MediaLibrary\Media::class,
        ],
    ];

    /**
     * Make this class
     * @return \WPTL\Observers\Kernel
     */
    public static function make()
    {
        return (new self);
    }

    /**
     * Register observers
     * @return void
     */
    public function observes()
    {
        $this->observeSingle();
        $this->observeBy();
    }

    /**
     * Observe One-on-One Model-Observer
     * @return void
     */
    private function observeSingle()
    {
        if (count($this->observers) > 0) {
            foreach ($this->observers as $model => $observer) {
                if (class_exists($model) && class_exists($observer)) {
                    $model::observe($observer);
                }
            }
        }
    }

    /**
     * One observer observed by many models
     * @return void
     */
    private function observeBy()
    {
        if (count($this->observeBy) > 0) {
            foreach ($this->observeBy as $observer => $models) {
                foreach ($models as $model) {
                    if (class_exists($model) && class_exists($observer)) {
                        $model::observe($observer);
                    }
                }
            }
        }
    }
}
