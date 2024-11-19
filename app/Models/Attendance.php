<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable = [
        'engineer_id',
        'attendance_time',
        'departure_time',
        'break_time',
        'day',
        'date',
    ];

    public function engineer()
    {
        return $this->belongsTo(Engineer::class);
    }

    
}
