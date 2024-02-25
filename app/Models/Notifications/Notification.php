<?php

namespace App\Models\Notifications;

use App\Models\Traits\HasUuid;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use HasFactory,SoftDeletes,HasUuid;

    protected $fillable =
    [
        'type',
        'notifiable_type',
        'notifiable_id',
        'data'
    ];

    public function user(){
        return $this->belongsTo(User::class,'notifiable_id');
    }

}
