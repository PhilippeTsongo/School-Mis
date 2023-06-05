<?php

namespace App\Models;

use App\Models\TimetableType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Timetable extends Model
{
    use HasFactory;

    protected $fillable = ['from_date', 'to_date', 'from_hour', 'to_hour', 'timetable_type_id', 'academic_year_id' ];

    public function time_table_type ()
    {
        return $this->belongs(TimetableType::class);
    }

    public function academic_year ()
    {
        return $this->belongs(AcademicYear::class);
    }
}
