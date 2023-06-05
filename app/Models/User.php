<?php

namespace App\Models;

use App\Models\Student;
use App\Models\Lecturer;
use App\Models\UserRole;
use App\Models\UserType;
use App\Models\UserToken;
use App\Models\StudentParent;
use App\Models\HeadDepartment;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'user_number',
        'name',
        'first_name',
        'last_name',
        'email',
        'image',
        'password',
        'password_confirmation',
        'user_role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userToken(){
        return $this->hasOne(UserToken::class);
    }

    public function user_role()
    {
        return $this->belongsTo(UserRole::class);
    }

    public function head_department (){
        return $this->hasOne(HeadDepartment::class);
    }

    public function student_parent (){
        return $this->hasOne(StudentParent::class);
    }

    public function student (){
        return $this->hasOne(Student::class);
    }

    public function lecturer (){
        return $this->hasOne(Lecturer::class);
    }
}
