<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;use Illuminate\Support\Str;

class Stakeholder extends Model
{
    use HasFactory;

    protected $keyType='string';

    protected $primaryKey='id';

    public $incrementing = false;




    protected $fillable=[
        'user_id',
        'parent_id',
        'representative_government_agency',
        'industrial_area_id',
        'tent_company_state',
        'company_representative_name',
        'job_title',
        'infrastructures_state',
        'infrastructure_type'
    ];


    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
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
        return $this->hasMany(Service::class,'stakeholder_id');
    }

    public function registration_requests()
    {
        return $this->hasMany(Registration_request::class,'stakeholder_id');
    }

    public function timelines()
    {
        return $this->hasMany(Timeline::class,'stakeholder_id');
    }

    public function sent_time_line_share_requests()
    {
        return $this->hasMany(Timeline_shares_request::class,'send_stakeholder_id');
    }

    public function reciver_time_line_share_requests()
    {
        return $this->hasMany(Timeline_shares_request::class,'receive_stakeholder_id');
    }

    public function timeline_events()
    {
        return $this->hasMany(Timeline_event::class,'stakeholder_id');
    }

    public function timeline_quires()
    {
        return $this->hasMany(Timeline_quiry::class,'stakeholder_id');
    }

    public function entities()
    {
        return $this->hasMany(Entity::class,'stakeholder_id');
    }

    public function shipments()
    {
        return $this->hasMany(Shipment::class,'stakeholder_id');
    }

    public function suppliers()
    {
        return $this->hasMany(Supplier::class,'stakeholder_id');
    }

    public function employees()
    {
        return $this->hasMany(Employee::class,'stakeholder_id');
    }

    public function wastes()
    {
        return $this->hasMany(Waste::class,'stakeholder_id');
    }

    public function industrial_area()
    {
        return $this->belongsTo(Industrial_area::class,'industrial_area_id');
    }
}
