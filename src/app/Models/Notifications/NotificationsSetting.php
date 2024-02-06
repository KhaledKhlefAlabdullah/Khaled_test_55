<?php

namespace App\Models\Notifications;

use App\Models\Category;
use App\Models\Dam;
use App\Models\MonitoringPoint;
use App\Models\Traits\HasUuid;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotificationsSetting extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    public $incrementing = false;


    protected $fillable = [
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
        return $this->belongsTo(User::class, 'user_id');
    }

    public function dams()
    {
        return $this->belongsToMany(Dam::class, 'dams_notification_settings', 'notification_setting_id', 'dam_id');
    }

    public function main_category()
    {
        return $this->belongsTo(Category::class, 'main_category_id');
    }

    public function sub_category()
    {
        return $this->belongsTo(Category::class, 'sub_category_id');
    }

    public function monitoring_points()
    {
        return $this->belongsToMany(MonitoringPoint::class, 'monitoring_points_notification_settings', 'notifications_setting_id', 'monitoring_point_id');
    }
}
