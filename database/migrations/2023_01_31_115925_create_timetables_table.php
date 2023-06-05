<?php

use App\Models\AcademicYear;
use App\Models\TimetableType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('timetables', function (Blueprint $table) {
            $table->id();
            $table->date('from_date');
            $table->dateTime('to_date');
            $table->date('from_hour');
            $table->dateTime('to_hour');
            $table->foreignIdFor(TimetableType::class);
            $table->foreignIdFor(AcademicYear::class);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('timetables');
    }
};
