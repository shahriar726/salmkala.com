<?php

namespace App\Models;

use App\Models\City;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory;
    protected $guarded=['id'];

    public function city()
    {
        return $this->hasOne(IranCity::class,'id','city_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
