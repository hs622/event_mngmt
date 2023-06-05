<?php

namespace App\Models;

use App\Models\City;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillabel = [
        'name',
        'slug',
        'status'
    ];

    public function city() {
        return $this->hasMany(City::class, 'country_id', 'id');
    }
}
