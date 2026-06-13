<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('school_profiles', function (Blueprint $table) {
            if (Schema::hasColumn('school_profiles', 'video_url')) {
                $table->dropColumn('video_url');
            }
            $table->string('video_path')->nullable()->after('history');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('school_profiles', function (Blueprint $table) {
            $table->dropColumn('video_path');
            $table->string('video_url')->nullable()->after('history');
        });
    }
};
