<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'department_id',
        'periodic_maintenance',
        'country',
        'company',
        'status',
        'date',
        'location',
        'nots'
    ];

    public function department()
    {
    return $this->belongsTo('App\Models\Department');
    }

    public function details()
    {
        return $this->hasMany(DeviceDetail::class);
    }

}
