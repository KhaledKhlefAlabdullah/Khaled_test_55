<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Waste extends Model
{
    use HasFactory, HasUuid;
    protected $keyType='string';
    protected $primaryKey='id';
    public $incrementing = false;

    protected $fillable=[
        'route_id',
        'waste_disposal_location_id',
        'stakeholder_id',
        'waste_name',
        'location',
        'contact_info'
    ];

    public function stakeholder()
    {
        return $this->belongsTo(Stakeholder::class,'stakeholder_id');
    }

    public function route_entity()
    {
        return $this->belongsTo(Entity::class,'route_id');
    }

    public function disposal_location_entity()
    {
        return $this->belongsTo(Entity::class,'waste_disposal_location_id');
    }

    public function disaster_reports()
    {
        return $this->hasMany(Disaster_report::class,'waste_id');
    }
}
