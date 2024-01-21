<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Supplier extends Model
{
    use HasFactory;

    protected $keyType='string';
    protected $primaryKey='id';
    public $incrementing = false;




    protected $fillable=[
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
        return $this->belongsTo(Stakeholder::class,'stakeholder_id');
    }

    public function route_entity()
    {
        return $this->belongsTo(Entity::class,'route_id');
    }

    public function material_entity()
    {
        return $this->belongsTo(Entity::class,'material_id');
    }

    public function disaster_report()
    {
        return $this->hasMany(Disaster_report::class,'supplier_id');
    }
}
