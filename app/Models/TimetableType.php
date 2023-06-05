<?php

namespace App\Models;

use App\Models\Timetable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TimetableType extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug_name'];

    public function time_table ()
    {
        return $this->hasMany(Timetable::class);
    }
}