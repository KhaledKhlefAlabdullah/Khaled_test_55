<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $primaryKey='id';
    public $incrementing = false;
    protected $fillable=[
        'id',
        'user_id',
        'category_id',
        'title',
        'slug',
        'body',
        'media_URL',
        'priority',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function category()
    {
        return $this->belongsTo('App\Models\Post_category');
    }
}
