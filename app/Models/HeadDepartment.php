<?php

namespace App\Models;

use App\Models\User;
use App\Models\Department;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HeadDepartment extends Model
{
    use HasFactory;

    protected $fillable = ['head_department_number', 'user_id', 'department_id', 'status'];

    public function user ()
    {
        return $this->belongsTo(User::class);
    }

    public function department ()
    {
        return $this->belongsTo(Department::class);
    }

}
