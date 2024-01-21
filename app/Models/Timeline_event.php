<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timeline_event extends Model
{
    use HasFactory;

    protected $keyType='string';

    protected $primaryKey='id';

    public $incrementing = false;

    protected $fillable=[
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
        return $this->belongsTo(Timeline::class,'timeline_id');
    }

    public function stakeholder()
    {
        return $this->belongsTo(Stakeholder::class,'stakeholder_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'category_is');
    }

    public function timeline_quires()
    {
        return $this->hasMany(Timeline_quiry::class,'timeline_event_id');
    }
}
