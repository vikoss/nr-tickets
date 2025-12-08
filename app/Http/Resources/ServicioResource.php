<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServicioResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'tipo_servicio' => $this->tipo_servicio,
            'tipo_servicio_label' => $this->tipo_servicio_label,
            'numero_serie' => $this->numero_serie,
            'fecha' => $this->fecha->toIso8601String(),
            'fecha_formatted' => $this->fecha->format('d/m/Y H:i'),
            'user' => new UserResource($this->whenLoaded('user')),
            'sucursal' => new SucursalResource($this->whenLoaded('sucursal')),
            'evidencias' => EvidenciaResource::collection($this->whenLoaded('evidencias')),
            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
        ];
    }
}
