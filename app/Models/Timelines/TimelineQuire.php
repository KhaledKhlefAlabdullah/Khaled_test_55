<?php

namespace App\Models\Timelines;

use App\Models\Stakeholder;
use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TimelineQuire extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    public $incrementing = false;


    protected $fillable = [
        'timeline_event_id',
        'stakeholder_id',
        'inquiry'
    ];

    public function timeline_event()
    {
        return $this->belongsTo(TimelineEvent::class, 'timeline_event_id');
    }

    public function stakeholder()
    {
        return $this->belongsTo(Stakeholder::class, 'stakeholder_id');
    }
}
