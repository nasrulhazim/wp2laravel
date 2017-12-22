<?php

namespace WPTL\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;
use Spatie\Permission\Traits\HasRoles;
use WPTL\Traits\HasMediaExtended;
use WPTL\Traits\HasSlugExtended;
use WPTL\Traits\HasThumbnail;
use WPTL\Traits\LogsActivityExtended;

class User extends Authenticatable implements HasMediaConversions
{
    use HasMediaExtended, HasThumbnail, HasRoles, HasSlugExtended, LogsActivityExtended, Notifiable, SoftDeletes;

    /**
     * Create Slug From
     * @var array
     */
    protected $slug_from = ['name'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Has Many Posts
     * @return \WPTL\Models\Post
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

}
