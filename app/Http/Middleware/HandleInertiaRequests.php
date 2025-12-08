<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = $request->user();

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $user ? [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'numero_empleado' => $user->numero_empleado,
                    'sucursal' => $user->sucursal ? [
                        'id' => $user->sucursal->id,
                        'nombre' => $user->sucursal->nombre,
                    ] : null,
                    'is_admin' => $user->isAdmin(),
                    'is_tecnico' => $user->isTecnico(),
                ] : null,
            ],
            'branding' => [
                'app_name' => config('branding.app_name'),
                'company_name' => config('branding.company_name'),
                'logos' => config('branding.logos'),
            ],
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
            ],
        ];
    }
}
