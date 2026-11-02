<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointment_slots', function (Blueprint $table) {
            $table->date('date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->integer('capacity')->default(1);
            $table->boolean('is_available')->default(true);
        });
    }

    public function down(): void
    {
        Schema::table('appointment_slots', function (Blueprint $table) {
            $table->dropColumn([
                'date',
                'start_time',
                'end_time',
                'capacity',
                'is_available',
            ]);
        });
    }
};
