<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $primaryKey='id';
    public $incrementing = false;
    protected $fillable=[
        'id',
        'name',
        'type',
        'parent_id'
    ];

    public function posts()
    {
        return $this->hasMany('App\Models\Post','category_id');
    }
    public function files()
    {
        return $this->hasMany('App\Models\File','category_id');
    }

    public function main_category_notifications_settings()
    {
        return $this->hasMany('App\Models\Notifications_setting','main_category_id');
    }

    public function sub_category_notifications_settings()
    {
        return $this->hasMany('App\Models\Notifications_setting','sub_category_id');
    }

}
