<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Creates the evidencias table for service evidence images.
     */
    public function up(): void
    {
        Schema::create('evidencias', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('servicio_id')->comment('Associated service');
            $table->string('path')->comment('File path relative to storage/app/public');
            $table->string('mime', 50)->comment('MIME type (image/jpeg, image/png)');
            $table->unsignedInteger('size')->comment('File size in bytes');
            $table->unsignedTinyInteger('orden')->default(0)->comment('Display order (0 or 1 for two images)');
            $table->timestamps();

            $table->foreign('servicio_id')
                ->references('id')
                ->on('servicios')
                ->onDelete('cascade');

            $table->index(['servicio_id', 'orden']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evidencias');
    }
};
