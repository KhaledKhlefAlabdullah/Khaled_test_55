<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Monitoring_point extends Model
{
    use HasFactory;
    protected $keyType='string';

    protected $primaryKey='id';

    public $incrementing=false;

    protected $fillable=[
        'user_id',
        'name',
        'location',
        'point_type',
        'API_link',
        'is_custom',
        'water_level',
        'risk_indicators',
        'discharge',
        'source'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function  notifications_settings()
    {
        return $this->hasMany('App\Models\Monitoring_points_notification_setting','monitoring_point_id');
    }
}
