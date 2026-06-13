<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registrants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('academic_year_id')->constrained('academic_years')->onDelete('cascade');
            $table->string('registration_number')->unique(); // REG-YYYY-XXXX
            $table->string('name');
            $table->string('nisn', 10);
            $table->string('place_of_birth');
            $table->date('date_of_birth');
            $table->enum('gender', ['L', 'P']);
            $table->text('address');
            $table->string('previous_school');
            $table->string('phone_number');
            $table->string('parent_name');
            $table->foreignId('selected_major_id')->constrained('majors')->onDelete('cascade');
            $table->string('document_ijazah')->nullable(); // Storage path to PDF/image
            $table->string('document_akta')->nullable();   // Storage path to PDF/image
            $table->string('document_kk')->nullable();     // Storage path to PDF/image
            $table->string('document_foto')->nullable();   // Storage path to image
            $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registrants');
    }
};
