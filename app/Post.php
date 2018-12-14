<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ManagableByStringId;
use App\Traits\TimestampsAppendZ;

class Post extends Model
{
    use ManagableByStringId, TimestampsAppendZ;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'content'
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot() {
        parent::boot();
        static::creating(function ($post) {
            $post->string_id = $post->getUniqueStringId();
        });
    }

    /**
     * Get post's author.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * Get post's comments.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Comment', 'post_id')->orderBy('id', 'DESC');
    }

    /**
     * Get post's tags.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'post_tag', 'post_id', 'tag_id');
    }
}