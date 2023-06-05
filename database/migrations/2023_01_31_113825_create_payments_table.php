<?php

use App\Models\Student;
use App\Models\PaymentType;
use App\Models\AcademicYear;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_number');
            $table->string('payment_date');
            $table->double('amount');
            $table->string('month');
            $table->foreignIdFor(Student::class);
            $table->foreignIdFor(AcademicYear::class);
            $table->foreignIdFor(PaymentType::class);
            $table->timestamps();

        });
    }
    
    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
