<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'status'
    ];

    public function user() {
        return $this->belongsToMany(User::class, 'user_roles', 'user_id', 'role_id')
            ->withTimestamps();
    }
}
