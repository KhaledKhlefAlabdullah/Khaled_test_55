<?php

namespace App\Models\Timelines;

use App\Models\Stakeholder;
use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TimelineSharesRequest extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    public $incrementing = false;


    protected $fillable = [
        'timeline_id',
        'send_stakeholder_id',
        'receive_stakeholder_id',
        'status',
        'send_date',
        'end_date'
    ];

    public function timeline()
    {
        return $this->belongsTo(Timeline::class, 'timeline_id');
    }

    public function sender()
    {
        return $this->belongsTo(Stakeholder::class, 'send_stakeholder_id');
    }

    public function receiver()
    {
        return $this->belongsTo(Stakeholder::class, 'receive_stakeholder_id');
    }
}
