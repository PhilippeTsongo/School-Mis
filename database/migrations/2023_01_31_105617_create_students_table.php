<?php

use App\Models\User;
use App\Models\Cycle;
use App\Models\Classe;
use App\Models\Section;
use App\Models\AcademicYear;
use App\Models\StudentParent;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('student_number');
            $table->string('date_of_birth');
            $table->string('gender');
            $table->string('address');
            $table->string('tel');
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(StudentParent::class);
            $table->foreignIdFor(Cycle::class);
            $table->foreignIdFor(Classe::class);
            $table->foreignIdFor(AcademicYear::class);
            $table->string('status')->default('ACTIVE');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('students');
    }
};
