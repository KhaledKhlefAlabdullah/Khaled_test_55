<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    protected $keyType = 'string';
    protected $primaryKey = 'id';
    public $incrementing = false;


    protected $fillable = [
        'route_id',
        'material_id',
        'stakeholder_id',
        'public_id',
        'location',
        'contact_info',
        'slug',
        'is_available'
    ];


    public function stakeholder()
    {
        return $this->belongsTo(Stakeholder::class, 'stakeholder_id');
    }

    public function route_entity()
    {
        return $this->belongsTo(Entity::class, 'route_id');
    }

    public function material_entity()
    {
        return $this->belongsTo(Entity::class, 'material_id');
    }

    public function disaster_report()
    {
        return $this->hasMany(DisasterReport::class, 'supplier_id');
    }
}
