<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    protected $keyType = 'string';
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = [
        'route_id',
        'department_id',
        'station_id',
        'stakeholder_id',
        'public_id',
        'is_leader_shop',
        'slug',
        'phone_number'
    ];

    public function stakeholder()
    {
        return $this->belongsTo(Stakeholder::class, 'stakeholder_id');
    }

    public function route_entity()
    {
        return $this->belongsTo(Entity::class, 'route_id');
    }

    public function department_entity()
    {
        return $this->belongsTo(Entity::class, 'department_id');
    }

    public function station_entity()
    {
        return $this->belongsTo(Entity::class, 'station_id');
    }

    public function disaster_report()
    {
        return $this->hasMany(DisasterReport::class, 'employee_id');
    }
}
