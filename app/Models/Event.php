<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'description',
        'status',
    ];

    public function schedule() {
        return $this->hasOne(Schedule::class, 'event_id', 'id');
    }

    public function category() {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function enrollments() {
        return $this->hasMany(Enroll::class, 'event_id', 'id');
    }
}
