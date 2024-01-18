<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;
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
        return $this->belongsTo('User','user_id');
    }
}
