<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration_request extends Model
{
    use HasFactory;
    protected $keyType='string';

    protected $primaryKey='id';

    public $incrementing = false;

    protected $fillable=[
        'stakeholder_id',
        'company_name',
        'representative_name',
        'email',
        'password',
        'location',
        'phone_number',
        'job_title',
        'request_state',
        'failed_message'
    ];

    public function stakeholder()
    {
        return $this->belongsTo(Stakeholder::class,'stakeholder_id');
    }
}
