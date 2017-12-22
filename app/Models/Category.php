<?php

namespace WPTL\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use WPTL\Traits\HasSlugExtended;
use WPTL\Traits\LogsActivityExtended;

class Category extends Model
{
    use HasSlugExtended, LogsActivityExtended, SoftDeletes;

    /**
     * Create Slug From
     * @var array
     */
    protected $slug_from = ['name'];

    /**
     * Guarded Fields
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}
