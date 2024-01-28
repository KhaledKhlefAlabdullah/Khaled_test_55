<?php

namespace App\Models\Timelines;

use App\Models\Stakeholder;
use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Timeline_shares_request extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    public $incrementing = false;


    protected $fillable = [
        'user_id',
        'parent_id',
        'representative_government_agency',
        'tenant_company_state',
        'company_representative_name',
        'job_title',
        'infrastructures_state',
        'infrastructure_type'
    ];

    public function timeline()
    {
        return $this->belongsTo(Timeline::class, 'timeline_id');
    }

    public function sender()
    {
        return $this->belongsTo(Stakeholder::class, 'send_stakeholder_id');
    }

    public function receiver()
    {
        return $this->belongsTo(Stakeholder::class, 'receive_stakeholder_id');
    }
}
