<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonitoringPointsNotificationSetting extends Model
{
    use HasFactory;

    protected $primaryKey='id';

    public $incrementing=false;

    protected $fillable=[
        'monitoring_point_id',
        'notifications_setting_id'
    ];

    public function monitoring_point()
    {
        return $this->belongsTo('App\Models\MonitoringPoint', 'monitoring_point_id');
    }

    public function notifications_setting()
    {
        return $this->belongsTo('App\Models\NotificationsSetting', 'notifications_setting_id');
    }
}
