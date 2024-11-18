<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'device_id',
        'img',
    ]; 
}
