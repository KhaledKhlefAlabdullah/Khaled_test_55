<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timeline extends Model
{
    use HasFactory;

    protected $keyType='string';

    protected $primaryKey='id';

    public $incrementing = false;

    protected $fillable=[
        'stakeholder_id'
    ];

    public function stakeholder()
    {
        return $this->belongsTo(Stakeholder::class,'stakeholder_id');
    }

    public function timeline_shares_requests()
    {
        return $this->hasMany(Timeline_shares_request::class,'timeline_id');
    }

    public function timeline_events()
    {
        return $this->hasMany(Timeline_event::class,'timeline_id');
    }
}
