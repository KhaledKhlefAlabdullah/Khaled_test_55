<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory, HasUuid;
    protected $keyType='string';

    protected $primaryKey='id';
    public $incrementing = false;
    protected $fillable=[
        'chat_name'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class,'chat_members','chat_id','user_id');
    }

    public function mesages()
    {
        return $this->hasMany(Message::class,'chat_id');
    }
}
