<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Industrial_area extends Model
{
    use HasFactory;

    protected $primaryKey='id';
    protected $keyType='string';
    public $incrementing=false;
    protected $fillable=[
        "user_id",
        "name",
        "address",
        "representative_name",
        "representative_email"
    ];

    public function industrial_area_representative()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function stakeholders()
    {
        return $this->hasMany(Stakeholder::class,'industrial_area_id');
    }
}
