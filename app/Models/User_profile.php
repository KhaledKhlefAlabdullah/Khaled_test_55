<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_profile extends Model
{
    use HasFactory, HasUuid;
    protected $keyType='string';

    protected $primaryKey='id';
    public $incrementing = false;

    protected $fillable=[
      'user_id',
      'name',
      'contact_person',
      'avatar_URL',
      'location',
      'phone_number'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
