<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_profiles', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->text('vision');
            $table->text('mission');
            $table->string('principal_welcome_name')->nullable();
            $table->string('principal_welcome_title')->nullable();
            $table->text('principal_welcome_text')->nullable();
            $table->string('principal_welcome_photo')->nullable();
            $table->text('history')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_profiles');
    }
};
