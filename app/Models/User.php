<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUuid;
    protected $keyType='string';
    protected $primaryKey='id';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'stakeholder_type',
        'password',
        'isActive',
        'deleted_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function user_profile()
    {
        return $this->hasOne(User_profile::class,'user_id');
    }

    public function portal_settings()
    {
        return $this->hasMany(Portal_setting::Class,'user_id');
    }

    public function pages()
    {
        return $this->hasMany(Page::class,'user_id');
    }

    public function participating_entities()
    {
        return $this->hasMany(Participating_entity::class,'user_id');
    }

    public function contact_us_messages()
    {
        return $this->hasMany(Contact_us_message::class,'user_id');
    }

    public function chats()
    {
        return $this->belongsToMany(Chat::class,'chat_members','user_id','chat_id');
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class,'user_id');
    }

    public function dams()
    {
        return $this->hasMany(Dam::class,'user_id');
    }

    public function monitoring_points()
    {
        return $this->hasMany(Monitoring_point::class,'user_id');
    }

    public function stakholder()
    {
        return $this->hasOne(Stakeholder::class,'user_id');
    }

    public function registration_requests()
    {
        return $this->hasMany(Registration_request::class,'user_id');
    }

    public function industrial_area()
    {
        return $this->hasOne(Industrial_area::class,'user_id');
    }
}
