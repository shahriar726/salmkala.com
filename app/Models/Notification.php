<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $guarded=['id'];
    protected $casts = ['data'=>'array'];
    use HasFactory;
}
