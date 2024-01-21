<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Portal_setting extends Model
{
    use HasFactory;
    protected $keyType='string';

    protected $primaryKey='id';
    public $incrementing = false;



    protected $fillable=[
        'user_id',
        'key',
        'value'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

}
