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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table
                ->foreignId('project_id')
                ->after('id')
                ->constrained('projects')
                ->cascadeOnDelete();
            $table->string('title');
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->integer('price')->comment('Цена в копейках');
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
