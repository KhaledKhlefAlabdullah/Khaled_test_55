<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $keyType='string';

    protected $primaryKey='id';
    public $incrementing = false;
    protected $fillable=[
        'id',
        'user_id',
        'category_id',
        'page_id',
        'title',
        'slug',
        'body',
        'media_URL',
        'priority',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function page()
    {
        return $this->belongsTo(Page::class,'page_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }
}
