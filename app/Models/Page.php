<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory, HasUuid;
    protected $keyType='string';

    protected $primaryKey='id';
    public $incrementing = false;
    protected $fillable=[
        'user_id',
        'title',
        'type',
        'description',
        'phone_number',
        'location',
        'start_time',
        'end_time'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class,'page_id');
    }

}
