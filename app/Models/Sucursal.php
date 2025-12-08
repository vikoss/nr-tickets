<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sucursal extends Model
{
    use HasFactory, HasUuids;

    /**
     * The table associated with the model.
     */
    protected $table = 'sucursales';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nombre',
        'codigo',
    ];

    /**
     * Get the users assigned to this branch.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'sucursal_id');
    }

    /**
     * Get the employees assigned to this branch.
     */
    public function empleados(): HasMany
    {
        return $this->hasMany(Empleado::class);
    }

    /**
     * Get all services performed at this branch.
     */
    public function servicios(): HasMany
    {
        return $this->hasMany(Servicio::class);
    }
}
