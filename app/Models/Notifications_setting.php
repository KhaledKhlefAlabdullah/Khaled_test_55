<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifications_setting extends Model
{
    use HasFactory;
    protected $keyType='string';

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
        return $this->belongsTo(User::class,'user_id');
    }

    public function dams()
    {
        return $this->belongsToMany(Dam::class,'dams_notification_settings','notification_setting_id','dam_id');
    }

    public function main_category()
    {
        return $this->belongsTo(Category::class,'main_category_id');
    }

    public function sub_category()
    {
        return $this->belongsTo(Category::class,'sub_category_id');
    }

    public function  monitoring_points()
    {
        return $this->belongsToMany(Monitoring_point::class,'monitoring_points_notification_settings','notifications_setting_id','monitoring_point_id');
    }
}
