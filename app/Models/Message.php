<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $primaryKey='id';

    public $incrementing=false;

    protected $fillable=[
        'id',
        'sender_id',
        'receiver_id',
        'chat_id',
        'message',
        'media_URL',
        'message_type',
        'is_read',
        'is_edite',
        'is_starred'
    ];

    public function sender()
    {
        return $this->belongsTo('App\Models\User','sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo('App\Models\User','receiver_id');
    }

    public function chat()
    {
        return $this->belongsTo('App\Models\Chat','chat_id');
    }
}
