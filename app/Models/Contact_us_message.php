<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Contact_us_message extends Model
{
    use HasFactory, HasUuid;
    protected $keyType='string';
    protected $primaryKey='id';
    public $incrementing = false;

    protected $fillable=[
        'user_id',
        'message',
        'is_read',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
