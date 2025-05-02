<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('close_approach_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('neo_object_id')
                ->constrained()
                ->onDelete('cascade');
            $table->dateTime('close_approach_date_full');
            $table->float('relative_velocity');
            $table->float('miss_distance');
            $table->timestamps();
            $table->unique(['neo_object_id', 'close_approach_date_full'], 'neo_close_date_unique');
            $table->index('close_approach_date_full');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('close_approach_data');
    }
};
