<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('neo_objects', function (Blueprint $table) {
            $table->id();
            $table->string('reference_id')->unique();
            $table->string('name')->index();
            $table->float('estimated_diameter_min');
            $table->float('estimated_diameter_max');
            $table->boolean('is_hazardous')->index();
            $table->float('absolute_magnitude');
            $table->timestamps();

            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('neo_objects');
    }
};
