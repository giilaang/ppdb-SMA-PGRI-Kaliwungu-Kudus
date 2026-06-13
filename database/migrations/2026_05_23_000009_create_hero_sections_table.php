<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hero_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('academic_year_id')->constrained('academic_years')->onDelete('cascade');
            $table->string('title');
            $table->text('subtitle');
            $table->string('register_button_text')->default('Daftar Sekarang');
            $table->string('brochure_button_text')->default('Download Brosur');
            $table->string('banner_image_1')->nullable();
            $table->string('banner_image_2')->nullable();
            $table->string('banner_image_3')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hero_sections');
    }
};
