<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Registration_request extends Model
{
    use HasFactory, HasUuid, SoftDeletes;
    protected $keyType='string';

    protected $primaryKey='id';

    public $incrementing = false;

    protected $fillable=[
        'industrial_area_id',
        'name',
        'representative_name',
        'email',
        'password',
        'location',
        'phone_number',
        'job_title',
        'request_state',
        'failed_message'
    ];

    public function industrial_area()
    {
        return $this->belongsTo(Industrial_area::class,'industrial_area_id');
    }
}
