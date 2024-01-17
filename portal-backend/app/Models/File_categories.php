<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File_categories extends Model
{
    use HasFactory;
    protected $primaryKey='id';
    public $incrementing = false;

    protected $fillable=[
        'id',
        'name'
    ];
    public function files()
    {
        return $this->hasMany('App\Models\File');
    }
}
