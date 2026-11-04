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
        Schema::create('entity_fields', function (Blueprint $table) {
            $table->id();

            $table->foreignId('entity_id')
                ->constrained('entities')
                ->cascadeOnDelete();

            $table->string('field');

            $table->timestamps();

            $table->unique(['entity_id', 'field']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entity_fields');
    }
};
