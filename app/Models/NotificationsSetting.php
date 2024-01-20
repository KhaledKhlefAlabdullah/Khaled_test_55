<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationsSetting extends Model
{
    use HasFactory;

    protected $primaryKey='id';

    public $incrementing=false;

    protected $fillable=[
        'id',
        'user_id',
        'main_category_id',
        'sub_category_id',
        'notification_state',
        'notification_level',
        'notification_priorities',
        'is_on',
        'note',
        'deleted_at'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }

    public function dams_notification_settings()
    {
        return $this->hasMany('App\Models\DamsNotificationSetting', 'notification_setting_id');
    }

    public function dams_notifications_settings()
    {
        return $this->hasMany('App\Models\DamsNotificationSetting', 'notification_setting_id');
    }

    public function main_category()
    {
        return $this->belongsTo('App\Models\Category','main_category_id');
    }

    public function sub_category()
    {
        return $this->belongsTo('App\Models\Category','sub_category_id');
    }

    public function  monitoring_points_notification_settings()
    {
        return $this->hasMany('App\Models\MonitoringPointsNotificationSetting', 'notifications_setting_id');
    }
}
