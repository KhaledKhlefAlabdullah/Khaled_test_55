<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_profile extends Model
{
    use HasFactory;
    protected $keyType='string';

    protected $primaryKey='id';
    public $incrementing = false;

    protected $fillable=[
      'id',
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
