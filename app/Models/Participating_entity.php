<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Participating_entity extends Model
{
    use HasFactory, HasUuid;
    protected $keyType='string';

    protected $primaryKey='id';
    public $incrementing = false;



    protected $fillable=[
        'user_id',
        'title',
        'media_URL',
        'media_type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
