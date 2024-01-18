<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $primaryKey='id';

    public $incrementing=false;

    protected $fillable=[
        'id',
        'user_id',
        'title',
        'description',
        'slug',
        'is_read',
        'notification_type',
        'deleted_at'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }
}
