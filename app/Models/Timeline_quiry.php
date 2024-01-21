<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Timeline_quiry extends Model
{
    use HasFactory, HasUuid;
    protected $keyType='string';

    protected $primaryKey='id';

    public $incrementing = false;




    protected $fillable=[
        'timeline_event_id',
        'stakeholder_id',
        'inquiry'
    ];

    public function timeline_event()
    {
        return $this->belongsTo(Timeline_event::class,'timeline_event_id');
    }

    public function stakeholder()
    {
        return $this->belongsTo(Stakeholder::class,'stakeholder_id');
    }
}
