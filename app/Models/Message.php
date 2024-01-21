<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Message extends Model
{
    use HasFactory, HasUuid;
    protected $keyType='string';

    protected $primaryKey='id';

    public $incrementing=false;

    protected $fillable=[
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
        return $this->belongsTo(User::class,'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class,'receiver_id');
    }

    public function chat()
    {
        return $this->belongsTo(Chat::class,'chat_id');
    }
}
