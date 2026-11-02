<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('appointment_slots', 'doctor_name')) {
            Schema::table('appointment_slots', function (Blueprint $table) {
                $table->string('doctor_name')->nullable()->after('id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('appointment_slots', 'doctor_name')) {
            Schema::table('appointment_slots', function (Blueprint $table) {
                $table->dropColumn('doctor_name');
            });
        }
    }
};