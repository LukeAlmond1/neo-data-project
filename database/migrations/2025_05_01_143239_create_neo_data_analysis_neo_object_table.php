<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('neo_data_analysis_neo_object', function (Blueprint $table) {
            $table->id();
            $table->foreignId('neo_data_analysis_id')->constrained()->onDelete('cascade');
            $table->foreignId('neo_object_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('neo_data_analysis_neo_object');
    }
};
