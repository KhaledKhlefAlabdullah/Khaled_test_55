<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Service extends Model
{
    use HasFactory;
    protected $keyType='string';

    protected $primaryKey='id';

    public $incrementing = false;




    protected $fillable=[
        'stakeholder_id',
        'category_id',
        'infrastructures_state',
        'slug',
        'description',
        'start_date',
        'end_date',
    ];

    public function stakeholder()
    {
        return $this->belongsTo(Stakeholder::class,'stakeholder_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }
}
