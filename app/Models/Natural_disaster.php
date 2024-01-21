<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Natural_disaster extends Model
{
    use HasFactory, HasUuid;

    protected $keyType='string';
    protected $primaryKey='id';
    public $incrementing = false;




    protected $fillable=[
        'name',
        'disaster_type',
        'disaster_date',
        'description',
        'location'
    ];

    public function disaster_reports()
    {
        return $this->hasMany(Disaster_report::class,'natural_disaster_id');
    }

}
