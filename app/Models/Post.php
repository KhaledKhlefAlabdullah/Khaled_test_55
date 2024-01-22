<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Post extends Model
{
    use HasFactory, HasUuid;
    protected $keyType='string';

    protected $primaryKey='id';

    public $incrementing=false;

    protected $fillable=[
        'user_id',
        'category_id',
        'page_id',
        'title',
        'slug',
        'body',
        'media_URL',
        'media_type',
        'is_priority',
        'priority_count',
        'is_general_news',
        'is_publish',
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
