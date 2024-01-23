<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Industrial_area extends Model
{
    use HasFactory,HasUuid;

    protected $primaryKey='id';
    protected $keyType='string';
    public $incrementing=false;
    protected $fillable=[
        "name",
        "address"
    ];


    public function user()
    {
        return $this->hasOne(User::class,'industrial_area_id');
    }

    public function stakeholders()
    {
        return $this->hasMany(Stakeholder::class,'industrial_area_id');
    }
}
