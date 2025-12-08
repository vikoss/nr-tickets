<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Creates the sucursales (branches) table with UUID primary key.
     */
    public function up(): void
    {
        Schema::create('sucursales', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nombre')->comment('Branch name');
            $table->string('codigo')->nullable()->comment('Branch code (optional)');
            $table->timestamps();

            $table->index('codigo');
        });

        // Add foreign key constraint for users.sucursal_id
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('sucursal_id')
                ->references('id')
                ->on('sucursales')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['sucursal_id']);
        });

        Schema::dropIfExists('sucursales');
    }
};
