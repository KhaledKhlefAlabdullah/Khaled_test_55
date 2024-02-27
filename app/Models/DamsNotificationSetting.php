<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DamsNotificationSetting extends Model
{
    use HasFactory,HasUuid,SoftDeletes;
    protected $keyType = 'string';

    protected $primaryKey = 'id';

    public $incrementing = false;
    protected $fillable=[
        'dam_id',
        'notification_setting_id'
    ];
}
