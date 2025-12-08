<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSucursalRequest;
use App\Http\Resources\SucursalResource;
use App\Models\Sucursal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SucursalController extends Controller
{
    /**
     * Display a listing of sucursales (branches).
     */
    public function index(Request $request): Response
    {
        // Only admin can manage sucursales
        if (! $request->user()->isAdmin()) {
            abort(403);
        }

        $sucursales = Sucursal::orderBy('nombre')->paginate(15);

        return Inertia::render('Admin/Sucursales/Index', [
            'sucursales' => SucursalResource::collection($sucursales),
        ]);
    }

    /**
     * Show the form for creating a new sucursal.
     */
    public function create(Request $request): Response
    {
        if (! $request->user()->isAdmin()) {
            abort(403);
        }

        return Inertia::render('Admin/Sucursales/Create');
    }

    /**
     * Store a newly created sucursal.
     */
    public function store(StoreSucursalRequest $request): RedirectResponse
    {
        Sucursal::create($request->validated());

        return redirect()
            ->route('admin.sucursales.index')
            ->with('success', 'Sucursal creada exitosamente.');
    }

    /**
     * Get all sucursales for API/dropdown use.
     */
    public function list(): \Illuminate\Http\JsonResponse
    {
        $sucursales = Sucursal::orderBy('nombre')->get();

        return response()->json([
            'data' => SucursalResource::collection($sucursales),
        ]);
    }
}
