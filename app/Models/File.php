<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class File extends Model
{
    use HasFactory;
    protected $keyType='string';
    protected $primaryKey='id';
    public $incrementing = false;




    protected $fillable=[
        'user_id',
        'category_id',
        'file_type',
        'title',
        'description',
        'version',
        'media_URL',
        'media_type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }
}
