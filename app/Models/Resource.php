<?php

namespace App\Models;

use App\Models\Timelines\TimelineEvent;
use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resource extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    protected $keyType = 'string';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $fillable =[
        'stakeholder_id',
        'resource',
        'quantity',
        'is_avilable'
    ];

    public function event()
    {
        return $this->belongsToMany(TimelineEvent::class,'event_resources','resource_id','event_id');
    }

    public function stakeholder()
    {
        return $this->belongsTo(Stakeholder::class,'stakeholder_id');
    }
}
