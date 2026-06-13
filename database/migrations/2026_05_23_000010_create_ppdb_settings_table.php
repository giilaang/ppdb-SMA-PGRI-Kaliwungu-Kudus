<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ppdb_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('academic_year_id')->constrained('academic_years')->onDelete('cascade');
            $table->enum('status', ['open', 'closed'])->default('closed');
            $table->integer('quota')->default(100);
            $table->text('requirements_text'); // list of requirements (markdown/html/plaintext)
            $table->text('flow_text');         // description of registration flow
            $table->text('fees_text')->nullable(); // info biaya
            $table->text('schedule_text')->nullable(); // info jadwal
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ppdb_settings');
    }
};
