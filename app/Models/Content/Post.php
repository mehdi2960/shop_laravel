<?php

namespace App\Models\Content;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;

    use HasFactory, SoftDeletes,Sluggable;

    protected $fillable = ['title', 'slug', 'summary', 'body', 'image', 'status','tags','published_at','author_id','category_id','commentable'];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    protected $casts = ['image' => 'array'];

    public function postCategory()
    {
        return $this->belongsTo(PostCategory::class,'category_id');
    }
}
