<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    protected $primaryKey='id';
    public $incrementing = false;
    protected $fillable=[
        'id',
    ];

    public function chat_members()
    {
        return $this->hasMany('App\Models\Chat_member','chat_id');
    }

    public function mesages()
    {
        return $this->hasMany('App\Models\Message','chat_id');
    }
}
