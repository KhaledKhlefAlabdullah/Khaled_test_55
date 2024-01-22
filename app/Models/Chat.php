<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chat extends Model
{
    use HasFactory, HasUuid;
    protected $keyType='string';

    protected $primaryKey='id';

    public $incrementing = false;

    protected $fillable=[
        'chat_name'
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class,'chat_members','chat_id','user_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class,'chat_id');
    }
}
