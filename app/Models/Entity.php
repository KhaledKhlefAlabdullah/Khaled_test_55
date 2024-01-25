<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entity extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    protected $keyType = 'string';
    protected $primaryKey = 'id';
    public $incrementing = false;


    protected $fillable = [
        'stakeholder_id',
        'category_id',
        'name',
        'slug',
        'public_id',
        'phone_number',
        'location',
        'from',
        'to',
        'usage',
        'quantity',
        'is_available',
        'available_quantity',
        'note',
        'description'
    ];

    public function stakeholder()
    {
        return $this->belongsTo(Stakeholder::class, 'stakeholder_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function route_shipments()
    {
        return $this->hasMany(Shipment::class, 'route_id');
    }

    public function product_shipments()
    {
        return $this->hasMany(Shipment::class, 'product_id');
    }

    public function customer_shipments()
    {
        return $this->hasMany(Shipment::class, 'customer_id');
    }

    public function route_suppliers()
    {
        return $this->hasMany(Supplier::class, 'route_id');
    }

    public function material_suppliers()
    {
        return $this->hasMany(Supplier::class, 'material_id');
    }

    public function route_employees()
    {
        return $this->hasMany(Employee::class, 'route_id');
    }

    public function department_employees()
    {
        return $this->hasMany(Employee::class, 'department_id');
    }

    public function station_employees()
    {
        return $this->hasMany(Employee::class, 'station_id');
    }

    public function route_wastes()
    {
        return $this->hasMany(Waste::class, 'route_id');
    }

    public function disposal_location_wastes()
    {
        return $this->hasMany(Waste::class, 'waste_disposal_location_id');
    }

    public function disaster_report()
    {
        return $this->hasMany(Disaster_report::class, 'entity_id');
    }
}
