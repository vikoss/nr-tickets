<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Creates the servicios table with UUID primary key.
     * Note: Services cannot be edited after creation.
     */
    public function up(): void
    {
        Schema::create('servicios', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->comment('Technician who created the service');
            $table->uuid('sucursal_id')->comment('Branch where service was performed');
            $table->string('tipo_servicio')->comment('Service type: instalacion_gps, retiro_gps, cambio_equipo');
            $table->string('numero_serie', 128)->comment('GPS serial number (5-128 chars)');
            $table->timestamp('fecha')->comment('Service date/time in CDMX timezone');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('sucursal_id')
                ->references('id')
                ->on('sucursales')
                ->onDelete('cascade');

            $table->index('tipo_servicio');
            $table->index('fecha');
            $table->index(['user_id', 'fecha']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicios');
    }
};
