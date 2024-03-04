<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shipment extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    protected $keyType = 'string';
    protected $primaryKey = 'id';
    public $incrementing = false;


    protected $fillable = [
        'route_id',
        'product_id',
        'customer_id',
        'stakeholder_id',
        'public_id',
        'name',
        'description',
        'location',
        'contact_info'
    ];

    public function stakeholder()
    {
        return $this->belongsTo(Stakeholder::class, 'stakeholder_id');
    }

    public function route()
    {
        return $this->belongsTo(Entity::class, 'route_id');
    }

    public function product()
    {
        return $this->belongsTo(Entity::class, 'product_id');
    }

    public function customer()
    {
        return $this->belongsTo(Entity::class, 'customer_id');
    }

    public function disaster_report()
    {
        return $this->belongsTo(DisasterReport::class, 'shipment_id');
    }
}


