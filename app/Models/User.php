<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey='id';
    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
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
        return $this->hasOne('App\Models\User_profile','user_id');
    }

    public function portal_settings()
    {
        return $this->hasMany('App\Models\Portal_setting','user_id');
    }

    public function participating_entities()
    {
        return $this->hasMany('App\Models\Participating_entity','user_id');
    }

    public function contact_us_messages()
    {
        return $this->hasMany('App\Models\Contact_us_message','user_id');
    }

    public function chat_member()
    {
        return $this->hasMany('App\Models\Chat_member','user_id');
    }

    public function sentMessages()
    {
        return $this->hasMany('App\Models\Message', 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany('App\Models\Message', 'receiver_id');
    }

    public function notifications()
    {
        return $this->hasMany('App\Models\Notification','user_id');
    }

    public function dams()
    {
        return $this->hasMany('App\Models\Dam','user_id');
    }

    public function monitoring_points()
    {
        return $this->hasMany('App\Models\Monitoring_point','user_id');
    }
}
