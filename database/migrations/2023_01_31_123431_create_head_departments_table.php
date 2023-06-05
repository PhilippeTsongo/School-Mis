<?php

use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('head_departments', function (Blueprint $table) {
            $table->id();
            $table->string('head_department_number');
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Department::class);
            $table->string('staus')->default('ACTIVE');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('head_departments');
    }
};
