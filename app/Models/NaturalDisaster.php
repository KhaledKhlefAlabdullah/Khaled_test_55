<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NaturalDisaster extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    protected $keyType = 'string';
    protected $primaryKey = 'id';
    public $incrementing = false;


    protected $fillable = [
        'name',
        'disaster_type',
        'disaster_date',
        'description',
        'location'
    ];

    public function disaster_reports()
    {
        return $this->hasMany(DisasterReport::class, 'natural_disaster_id');
    }

}
