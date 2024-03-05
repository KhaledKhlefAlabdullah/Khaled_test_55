<?php

namespace App\Models\Timelines;

use App\Models\Category;
use App\Models\Stakeholder;
use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TimelineEvent extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    public $incrementing = false;


    protected $fillable = [
        'timeline_id',
        'stakeholder_id',
        'category_id',
        'title',
        'start_date',
        'end_date',
        'description',
        'production_percentage',
        'is_active'
    ];

    public function timeline()
    {
        return $this->belongsTo(Timeline::class, 'timeline_id');
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_is');
    }

    public function timeline_quires()
    {
        return $this->hasMany(TimelineQuire::class, 'timeline_event_id');
    }
}
