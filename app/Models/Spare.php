<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spare extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'quantity',
        'department_id',
        'doctor_name',
        'img',
        'date',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
