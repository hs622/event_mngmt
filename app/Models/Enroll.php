<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Enroll extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'event_id',
        'user_id'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function event() {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }
}
