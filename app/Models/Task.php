<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'engineer_id',
        'department_id',
        'errands',
        'status',
        'priority',
        'date',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function engineer()
    {
        return $this->belongsTo(Engineer::class);
    }
}
