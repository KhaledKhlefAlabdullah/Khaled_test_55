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
        return $this->belongsTo(User::class,'user_id');
    }

    public function  notifications_settings()
    {
        return $this->belongsToMany(Notifications_setting::class,'monitoring_points_notification_settings','monitoring_point_id','notifications_setting_id');
    }
}
