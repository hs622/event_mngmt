<?php

namespace App\Models;

use App\Models\Country;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
    use SoftDeletes, HasFactory;
    
    protected $fillabel = [
        'country_id',
        'name',
        'slug',
        'status'
    ];

    public function country() {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }
}
