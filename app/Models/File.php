<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    protected $primaryKey='id';
    public $incrementing = false;

    protected $fillable=[
        'id',
        'user_id',
        'category_id',
        'file_type',
        'title',
        'description',
        'version',
        'file_URL',
        'image_URL',
        'video_URL'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }
    public function category()
    {
        return $this->belongsTo('App\Models\Category','category_id');
    }
}
