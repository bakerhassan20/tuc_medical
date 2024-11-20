<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'device_id',
        'work_done',
        'description',
        'quantity',
    ];

    // Relationship with Department
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // Relationship with Device
    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
