<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dam extends Model
{
    use HasFactory;

    protected $primaryKey='id';

    public $incrementing=false;

    protected $fillable=[
        'id',
        'user_id',
        'name',
        'location',
        'water_level',
        'discharge',
        'source'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }

    public function dams_notifications_settings()
    {
        return $this->hasMany('App\Models\DamsNotificationSetting', 'dam_id');
    }
}
