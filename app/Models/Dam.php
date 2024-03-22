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
        'source',
        'dam_data'
    ];
    //Dam_data=
    // {
    //     "datetime": "21-03-2024",
    //     "damname": "BHUMIBOL DAM",
    //     "waterlevel": 239.07,
    //     "tailwater": 139.77,
    //     "inflow": 1.17,
    //     "released": 25.08,
    //     "storage": 7799.42,
    //     "spillway": 0,
    //     "losses": 0,
    //     "evap": 0.07
    // }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function notifications_settings()
    {
        return $this->belongsToMany(NotificationsSetting::class, 'dams_notification_settings', 'dam_id', 'notification_setting_id');
    }
}
