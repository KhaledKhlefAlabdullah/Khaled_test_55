<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUsMessage extends Model
{
    use HasFactory;
    protected $primaryKey='id';
    public $incrementing = false;
    protected $fillable=[
        'id',
        'user_id',
        'message',
        'is_read',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }
}
