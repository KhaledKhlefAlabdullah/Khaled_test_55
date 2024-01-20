<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonitoringPoint extends Model
{
    use HasFactory;

    protected $primaryKey='id';

    public $incrementing=false;

    protected $fillable=[
        'id',
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
        return $this->belongsTo('App\Models\User','user_id');
    }

    public function  monitoring_points_notification_settings()
    {
        return $this->hasMany('App\Models\MonitoringPointsNotificationSetting', 'monitoring_point_id');
    }
}
