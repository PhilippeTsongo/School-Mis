<?php

namespace App\Models;

use App\Models\User;
use App\Models\Course;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lecturer extends Model
{
    use HasFactory;

    protected $fillable = ['lecturer_number', 'address', 'tel', 'user_id' ];

    public function courses ()
    {
        return $this->hasMany(Course::class);
    }

    public function user ()
    {
        return $this->belongs(User::class);
    }
}
