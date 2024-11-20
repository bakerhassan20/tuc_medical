<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'engineer_id',
        'type',
        'status',
        'date',
    ];

    // Define the relationship with the Department model
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // Define the relationship with the Engineer model
    public function engineer()
    {
        return $this->belongsTo(Engineer::class);
    }

    
}
