<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('slot_id')
                ->nullable()
                ->constrained('appointment_slots')
                ->nullOnDelete();

            $table->text('reason')->nullable();

            $table->enum('status', [
                'Pending',
                'Approved',
                'Rejected',
                'Cancelled',
                'Completed',
            ])->default('Pending');
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['slot_id']);

            $table->dropColumn([
                'user_id',
                'slot_id',
                'reason',
                'status',
            ]);
        });
    }
};
