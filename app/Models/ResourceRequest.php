<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResourceRequest extends Model
{
    use HasFactory, HasUuid, SoftDeletes;
    protected $keyType = 'string';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $fillable = [
        'sender_stakeholder_id',
        'receiver_stakeholder_id',
        'resource_id',
        'request_state',
        'quantity'
    ];

    public function sender_stakeholder()
    {
        return $this->belongsTo(Stakeholder::class, 'sender_stakeholder_id');
    }

    public function receiver_stakeholder()
    {
        return $this->belongsTo(Stakeholder::class, 'receiver_stakeholder_id');
    }

    public function resource(){
        return $this->belongsTo(Resource::class,'resource_id');
    }
}
