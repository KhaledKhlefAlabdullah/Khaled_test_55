<?php

namespace App\Models;

use App\Models\Timelines\Timeline;
use App\Models\Timelines\TimelineEvent;
use App\Models\Timelines\TimelineQuire;
use App\Models\Timelines\TimelineSharesRequest;
use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stakeholder extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    public $incrementing = false;


    protected $fillable = [
        'user_id',
        'representative_government_agency',
        'industrial_area_id',
        'tenant_company_state',
        'company_representative_name',
        'job_title',
        'infrastructures_state',
        'infrastructure_type'
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function parent()
    {
        return $this->belongsTo(Stakeholder::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Stakeholder::class, 'parent_id');
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'stakeholder_id');
    }

    public function timelines()
    {
        return $this->hasMany(Timeline::class, 'stakeholder_id');
    }

    public function sent_time_line_share_requests()
    {
        return $this->hasMany(TimelineSharesRequest::class, 'send_stakeholder_id');
    }

    public function reciver_time_line_share_requests()
    {
        return $this->hasMany(TimelineSharesRequest::class, 'receive_stakeholder_id');
    }

    public function timeline_events()
    {
        return $this->hasMany(TimelineEvent::class, 'stakeholder_id');
    }

    public function timeline_quires()
    {
        return $this->hasMany(TimelineQuire::class, 'stakeholder_id');
    }

    public function entities()
    {
        return $this->hasMany(Entity::class, 'stakeholder_id');
    }

    public function shipments()
    {
        return $this->hasMany(Shipment::class, 'stakeholder_id');
    }

    public function suppliers()
    {
        return $this->hasMany(Supplier::class, 'stakeholder_id');
    }

    public function employees()
    {
        return $this->hasMany(Employee::class, 'stakeholder_id');
    }

    public function wastes()
    {
        return $this->hasMany(Waste::class, 'stakeholder_id');
    }

    public function industrial_area()
    {
        return $this->belongsTo(IndustrialArea::class, 'industrial_area_id');
    }
}
