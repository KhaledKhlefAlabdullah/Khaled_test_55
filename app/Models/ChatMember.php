<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMember extends Model
{
    use HasFactory;
    protected $primaryKey='id';
    public $incrementing = false;
    protected $fillable=[
        'id',
        'chat_id',
        'user_id',
    ];

    public function chat()
    {
        return $this->belongsTo('App\Models\Chat','chat_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }
}
