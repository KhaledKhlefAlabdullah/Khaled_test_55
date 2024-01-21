<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $keyType='string';

    protected $primaryKey='id';

    public $incrementing = false;



    protected $fillable=[
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
        return $this->belongsTo(User::class,'user_id');
    }
}
