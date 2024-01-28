<?php

namespace App\Models;

use App\Models\Notifications\NotificationsSetting;
use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dam extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'name',
        'location',
        'water_level',
        'discharge',
        'source'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function notifications_settings()
    {
        return $this->belongsToMany(NotificationsSetting::class, 'dams_notification_settings', 'dam_id', 'notification_setting_id');
    }
}
