<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Servicio extends Model
{
    use HasFactory, HasUuids;

    /**
     * Service type constants for enum-like values.
     */
    public const TIPO_INSTALACION_GPS = 'instalacion_gps';

    public const TIPO_RETIRO_GPS = 'retiro_gps';

    public const TIPO_CAMBIO_EQUIPO = 'cambio_equipo';

    /**
     * Available service types.
     */
    public const TIPOS_SERVICIO = [
        self::TIPO_INSTALACION_GPS => 'Instalación de GPS',
        self::TIPO_RETIRO_GPS => 'Retiro de GPS',
        self::TIPO_CAMBIO_EQUIPO => 'Cambio de equipo',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'sucursal_id',
        'tipo_servicio',
        'numero_serie',
        'fecha',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'fecha' => 'datetime',
        ];
    }

    /**
     * Get the user (technician) who created this service.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the branch where the service was performed.
     */
    public function sucursal(): BelongsTo
    {
        return $this->belongsTo(Sucursal::class);
    }

    /**
     * Get the evidence images for this service.
     */
    public function evidencias(): HasMany
    {
        return $this->hasMany(Evidencia::class)->orderBy('orden');
    }

    /**
     * Get the human-readable service type label.
     */
    public function getTipoServicioLabelAttribute(): string
    {
        return self::TIPOS_SERVICIO[$this->tipo_servicio] ?? $this->tipo_servicio;
    }
}
