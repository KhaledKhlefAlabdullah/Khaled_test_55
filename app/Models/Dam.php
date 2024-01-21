<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Dam extends Model
{
    use HasFactory, HasUuid;
    protected $keyType='string';

    protected $primaryKey='id';

    public $incrementing=false;

    protected $fillable=[
        'user_id',
        'name',
        'location',
        'water_level',
        'discharge',
        'source'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function notifications_settings()
    {
        return $this->belongsToMany(Notifications_setting::class,'dams_notification_settings','dam_id','notification_setting_id');
    }
}
