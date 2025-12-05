<?php

namespace App\Http\Requests;

use App\Models\Servicio;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreServicioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Servicio::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $maxSizeKb = config('branding.evidence.max_size_kb', 5120);

        return [
            'tipo_servicio' => [
                'required',
                'string',
                Rule::in(array_keys(Servicio::TIPOS_SERVICIO)),
            ],
            'numero_serie' => [
                'required',
                'string',
                'min:5',
                'max:128',
                'regex:/^[a-zA-Z0-9\-_]+$/', // Alphanumeric with dash and underscore
            ],
            'evidencias' => [
                'required',
                'array',
                'size:2', // Exactly two images required
            ],
            'evidencias.*' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png',
                "max:{$maxSizeKb}",
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'tipo_servicio.required' => 'El tipo de servicio es requerido.',
            'tipo_servicio.in' => 'El tipo de servicio seleccionado no es válido.',
            'numero_serie.required' => 'El número de serie es requerido.',
            'numero_serie.min' => 'El número de serie debe tener al menos 5 caracteres.',
            'numero_serie.max' => 'El número de serie no puede exceder 128 caracteres.',
            'numero_serie.regex' => 'El número de serie solo puede contener letras, números, guiones y guiones bajos.',
            'evidencias.required' => 'Las evidencias (imágenes) son requeridas.',
            'evidencias.size' => 'Debe proporcionar exactamente 2 imágenes como evidencia.',
            'evidencias.*.image' => 'Cada evidencia debe ser una imagen.',
            'evidencias.*.mimes' => 'Las imágenes deben ser de tipo JPG o PNG.',
            'evidencias.*.max' => 'Cada imagen no puede superar los '.(config('branding.evidence.max_size_kb', 5120) / 1024).' MB.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'tipo_servicio' => 'tipo de servicio',
            'numero_serie' => 'número de serie',
            'evidencias' => 'evidencias',
        ];
    }
}
