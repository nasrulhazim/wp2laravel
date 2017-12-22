<?php

namespace WPTL\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;
use WPTL\Traits\HasMediaExtended;
use WPTL\Traits\HasSlugExtended;
use WPTL\Traits\HasThumbnail;
use WPTL\Traits\LogsActivityExtended;

class Post extends Model implements HasMediaConversions
{
    use HasMediaExtended, HasThumbnail, HasSlugExtended, LogsActivityExtended, SoftDeletes;

    /**
     * Create Slug From
     * @var array
     */
    protected $slug_from = ['title'];

    /**
     * Guarded Fields
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Author
     * @return \WPTL\WPTL\User
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
