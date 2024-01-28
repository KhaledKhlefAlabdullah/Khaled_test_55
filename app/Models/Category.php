<?php

namespace App\Models;

use App\Models\Notifications\NotificationsSetting;
use App\Models\Timelines\TimelineEvent;
use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\FlareClient\Http\Exceptions\BadResponseCode;

class Category extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    protected $keyType = 'string';
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'type',
        'parent_id'
    ];


    public static function boot()
    {
        parent::boot();

        static::saving(function ($category) {
            if ($category->parent_id === $category->id) {
                throw new BadResponseCode('The parent ID must not be the same as the class ID itself.',
                    422);
            }
            return true;
        });
    }


    public function posts()
    {
        return $this->hasMany(Post::class, 'category_id');
    }

    public function files()
    {
        return $this->hasMany(File::class, 'category_id');
    }

    public function main_category_notifications_settings()
    {
        return $this->hasMany(NotificationsSetting::class, 'main_category_id');
    }

    public function sub_category_notifications_settings()
    {
        return $this->hasMany(NotificationsSetting::class, 'sub_category_id');
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'category_id');
    }

    public function timeline_events()
    {
        return $this->hasMany(TimelineEvent::class, 'category_id');
    }

    public function entities()
    {
        return $this->hasMany(Entity::class, 'category_id');
    }
}
