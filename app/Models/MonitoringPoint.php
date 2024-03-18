<?php

namespace App\Models;

use App\Models\Notifications\NotificationsSetting;
use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MonitoringPoint extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'industrial_area_id',
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
        return $this->belongsTo(User::class, 'user_id');
    }

    public function notification_settings()
    {
        return $this->belongsToMany(NotificationsSetting::class, 'monitoring_points_notification_settings', 'monitoring_point_id', 'notifications_setting_id');
    }
}
