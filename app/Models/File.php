<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    protected $keyType = 'string';
    protected $primaryKey = 'id';
    public $incrementing = false;


    protected $fillable = [
        'user_id',
        'main_category_id',
        'sub_category_id',
        'version_id',
        'title',
        'description',
        'version',
        'media_url',
        'media_type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function main_category()
    {
        return $this->belongsTo(Category::class, 'main_category_id');
    }

    public function sub_category()
    {
        return $this->belongsTo(Category::class, 'sub_category_id');
    }
}
