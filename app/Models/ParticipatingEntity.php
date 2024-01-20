<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParticipatingEntity extends Model
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
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
