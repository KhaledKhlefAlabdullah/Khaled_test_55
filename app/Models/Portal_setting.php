<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portal_setting extends Model
{
    use HasFactory;

    protected $primaryKey='id';
    public $incrementing = false;
    protected $fillable=[
        'id',
        'user_id',
        'key',
        'value'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }

    public function pages()
    {
        return $this->hasMany('App\Models\Page','portal_setting_id');
    }
}
