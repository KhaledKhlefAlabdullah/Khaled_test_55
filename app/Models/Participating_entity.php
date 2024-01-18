<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participating_entity extends Model
{
    use HasFactory;
    protected $primaryKey='id';
    public $incrementing = false;
    protected $fillable=[
        'id',
        'user_id',
        'title',
        'media_URL',
        'media_type'
    ];

    public function user()
    {
        return $this->belongsTo('App\Mode ls\User','user_id');
    }
}
