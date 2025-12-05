<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServicioRequest;
use App\Http\Resources\ServicioResource;
use App\Models\Servicio;
use App\Models\Evidencia;
use App\Services\EvidenceImageService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class ServicioController extends Controller
{
    public function __construct(
        private EvidenceImageService $evidenceService
    ) {}

    /**
     * Display a listing of services.
     * Admin sees all, Tecnico sees only their own.
     */
    public function index(Request $request): Response
    {
        $user = $request->user();
        
        $query = Servicio::with(['user', 'sucursal', 'evidencias'])
            ->orderBy('fecha', 'desc');

        // Filter by user if not admin
        if (!$user->isAdmin()) {
            $query->where('user_id', $user->id);
        }

        // Apply filters
        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha', '>=', $request->input('fecha_desde'));
        }
        
        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha', '<=', $request->input('fecha_hasta'));
        }
        
        if ($request->filled('sucursal_id')) {
            $query->where('sucursal_id', $request->input('sucursal_id'));
        }
        
        if ($request->filled('tipo_servicio')) {
            $query->where('tipo_servicio', $request->input('tipo_servicio'));
        }

        $servicios = $query->paginate(15)->withQueryString();

        return Inertia::render('Services/Index', [
            'servicios' => ServicioResource::collection($servicios),
            'filters' => $request->only(['fecha_desde', 'fecha_hasta', 'sucursal_id', 'tipo_servicio']),
            'tiposServicio' => Servicio::TIPOS_SERVICIO,
        ]);
    }

    /**
     * Show the form for creating a new service.
     */
    public function create(Request $request): Response
    {
        $user = $request->user();
        $user->load('sucursal');

        return Inertia::render('Services/Create', [
            'userData' => [
                'name' => $user->name,
                'numero_empleado' => $user->numero_empleado,
                'sucursal' => $user->sucursal ? [
                    'id' => $user->sucursal->id,
                    'nombre' => $user->sucursal->nombre,
                ] : null,
            ],
            'tiposServicio' => Servicio::TIPOS_SERVICIO,
            'fechaActual' => Carbon::now(config('app.timezone'))->toIso8601String(),
        ]);
    }

    /**
     * Store a newly created service with evidences.
     */
    public function store(StoreServicioRequest $request): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validated();

        // User must have a sucursal assigned
        if (!$user->sucursal_id) {
            return back()->withErrors([
                'sucursal' => 'Debes tener una sucursal asignada para crear servicios.',
            ]);
        }

        DB::beginTransaction();

        try {
            // Create the service
            $servicio = Servicio::create([
                'user_id' => $user->id,
                'sucursal_id' => $user->sucursal_id,
                'tipo_servicio' => $validated['tipo_servicio'],
                'numero_serie' => $validated['numero_serie'],
                'fecha' => Carbon::now(config('app.timezone')),
            ]);

            // Process and store evidences
            foreach ($validated['evidencias'] as $orden => $file) {
                $imageData = $this->evidenceService->store($file, $servicio->id);
                
                Evidencia::create([
                    'id' => $imageData['evidenciaId'],
                    'servicio_id' => $servicio->id,
                    'path' => $imageData['path'],
                    'mime' => $imageData['mime'],
                    'size' => $imageData['size'],
                    'orden' => $orden,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('servicios.show', $servicio)
                ->with('success', 'Servicio registrado exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Clean up any uploaded files if we created them
            if (isset($servicio)) {
                $this->evidenceService->deleteServiceEvidences($servicio->id);
            }

            report($e);

            return back()->withErrors([
                'error' => 'Ocurrió un error al guardar el servicio. Por favor intente de nuevo.',
            ]);
        }
    }

    /**
     * Display the specified service.
     */
    public function show(Servicio $servicio): Response
    {
        $this->authorize('view', $servicio);

        $servicio->load(['user', 'sucursal', 'evidencias']);

        return Inertia::render('Services/Show', [
            'servicio' => new ServicioResource($servicio),
        ]);
    }
}
