<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    /**
     * Display the home page with navigation cards.
     */
    public function index(Request $request): Response
    {
        $user = $request->user();
        
        // Get some stats for the user
        $query = Servicio::query();
        
        if (!$user->isAdmin()) {
            $query->where('user_id', $user->id);
        }
        
        $serviciosCount = $query->count();
        $serviciosHoy = (clone $query)->whereDate('fecha', today())->count();

        return Inertia::render('Home', [
            'stats' => [
                'total_servicios' => $serviciosCount,
                'servicios_hoy' => $serviciosHoy,
            ],
            'isAdmin' => $user->isAdmin(),
        ]);
    }
}
