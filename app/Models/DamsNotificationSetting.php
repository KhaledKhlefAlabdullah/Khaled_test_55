<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DamsNotificationSetting extends Model
{
    use HasFactory;

    protected $primaryKey='id';

    public $incrementing=false;

    protected $fillable=[
        'id',
        'dam_id',
        'notification_setting_id'
    ];

    public function dam()
    {
        return $this->belongsTo('App\Models\Dam'.'dam_id');
    }

    public function notifications_setting()
    {
        return $this->belongsTo('App\Models\NotificationsSetting', 'notification_setting_id');
    }
}
