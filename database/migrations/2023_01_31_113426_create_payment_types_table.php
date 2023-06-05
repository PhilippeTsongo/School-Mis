<?php

use App\Models\AcademicYear;
use App\Models\Classe;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payment_types', function (Blueprint $table) {
            $table->id();
            $table->string('payment_type');
            $table->string('name');
            $table->string('slug_name');
            $table->double('total_amount');
            $table->string('date_creation');
            $table->foreignIdFor(Classe::class);
            $table->foreignIdFor(AcademicYear::class);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payment_types');
    }
};
