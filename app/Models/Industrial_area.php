<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
class Industrial_area extends Model
{
    use HasFactory,HasUuid, SoftDeletes;

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

    public function registration_requests(): HasMany
    {
        return $this->hasMany(Registration_request::class, 'industrial_area_id');
    }
}
