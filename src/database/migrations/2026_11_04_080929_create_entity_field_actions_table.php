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
        Schema::create('entity_field_actions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('entity_field_id')
                ->constrained('entity_fields')
                ->cascadeOnDelete();

            $table->string('action');

            $table->timestamps();

            $table->unique(['entity_field_id', 'action']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entity_field_actions');
    }
};
