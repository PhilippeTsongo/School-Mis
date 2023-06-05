<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Student;

class StudentParent extends Model
{
    use HasFactory;

    protected $fillable = ['parent_number', 'user_id', 'address', 'tel', 'status'];

    public function user ()
    {
        return $this->belongsTo(User::class);
    }

    public function students ()
    {
        return $this->hasMany(Student::class);
    }

}
