<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Industrial_area_representative extends Model
{
    use HasFactory;
    protected $primaryKey='id';
    public $incrementing = false;

    protected $fillable=[
        'id',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
