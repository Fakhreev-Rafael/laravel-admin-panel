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
        Schema::create('entity_sorts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('entity_field_id')
                ->unique()
                ->constrained('entity_fields')
                ->cascadeOnDelete();

            $table->boolean('is_default')->default(false);

            $table->enum('default_direction', ['asc', 'desc'])
                ->default('asc');

            $table->boolean('allow_asc')->default(true);
            $table->boolean('allow_desc')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entity_sorts');
    }
};
