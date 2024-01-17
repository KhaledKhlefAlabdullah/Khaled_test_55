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
        'isActive'
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
        return $this->belongsTo('App\Models\User_profile');
    }

    public function portal_activities()
    {
        return $this->hasMany('App\Models\Portal_activity');
    }

    public function posts()
    {
        return $this->hasMany('App\Models\Post');
    }

    public function files()
    {
        return $this->hasMany('App\Models\File');
    }

    public function industrial_area_representative()
    {
        return $this->hasOne('App\Models\Industrial_area_representative');
    }
}
