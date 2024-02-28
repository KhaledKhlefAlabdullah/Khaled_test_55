<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\FlareClient\Http\Exceptions\BadResponseCode;

class Message extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'chat_id',
        'message',
        'media_url',
        'message_type',
        'is_read',
        'is_edit',
        'is_starred'
    ];


    public static function boot()
    {
        parent::boot();

        static::saving(function ($message) {
            if ($message->sender_id === $message->receiver_id) {
                throw new BadResponseCode('You cannot send a message to yourself',
                    422);
            }
            return true;
        });
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function chat()
    {
        return $this->belongsTo(Chat::class, 'chat_id');
    }
}
