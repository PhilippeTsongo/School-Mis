<?php

use App\Models\AcademicYear;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('marks', function (Blueprint $table) {
            $table->id();
            $table->string('cat1');
            $table->string('cat2');
            $table->string('cat3');
            $table->foreignIdFor(Student::class);
            $table->foreignIdFor(Course::class);
            $table->foreignIdFor(AcademicYear::class);
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('marks');
    }
};
