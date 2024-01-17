<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portal_activity extends Model
{
    use HasFactory;
    protected $primaryKey='id';
    public $incrementing = false;

    protected $fillable=[
        'id',
        'user_id',
        'title',
        'content',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
