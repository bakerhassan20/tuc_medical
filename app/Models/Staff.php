<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;
    protected $fillable = [
        'engineer_id',
        'college_id',
        'department_id',
        'date',
        'img',
    ];

    // Relationships
    public function college()
    {
        return $this->belongsTo(Department::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
