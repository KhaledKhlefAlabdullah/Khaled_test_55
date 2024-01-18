<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dams_notification_setting extends Model
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
        return $this->belongsTo('App\Models\Notifications_setting','notification_setting_id');
    }
}
