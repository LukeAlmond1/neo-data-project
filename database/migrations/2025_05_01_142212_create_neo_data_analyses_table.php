<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('neo_data_analyses', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('total_neo_count');
            $table->float('avg_estimated_diameter_min');
            $table->float('avg_estimated_diameter_max');
            $table->float('max_velocity');
            $table->float('min_miss_distance');

            $table->timestamps();

            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('neo_data_analyses');
    }
};
