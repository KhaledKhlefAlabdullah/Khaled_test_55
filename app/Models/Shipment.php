<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Shipment extends Model
{
    use HasFactory, HasUuid;
    protected $keyType='string';
    protected $primaryKey='id';
    public $incrementing = false;




    protected $fillable=[
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
        return $this->belongsTo(Stakeholder::class,'stakeholder_id');
    }

    public function route_entity()
    {
        return $this->belongsTo(Entity::class,'route_id');
    }

    public function product_entity()
    {
        return $this->belongsTo(Entity::class,'product_id');
    }

    public function customer_entity()
    {
        return $this->belongsTo(Entity::class,'customer_id');
    }

    public function disaster_report()
    {
        return $this->belongsTo(Disaster_report::class,'shipment_id');
    }
}


