<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\SucursalResource;
use App\Http\Resources\UserResource;
use App\Models\Sucursal;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;

class AdminUserController extends Controller
{
    /**
     * Display a listing of users (admin only).
     */
    public function index(Request $request): Response
    {
        $this->authorize('viewAny', User::class);

        $users = User::with(['sucursal', 'roles'])
            ->orderBy('name')
            ->paginate(15);

        return Inertia::render('Admin/Users/Index', [
            'users' => UserResource::collection($users),
        ]);
    }

    /**
     * Show the form for creating a new user.
     */
    public function create(): Response
    {
        $this->authorize('create', User::class);

        $sucursales = Sucursal::orderBy('nombre')->get();

        return Inertia::render('Admin/Users/Create', [
            'sucursales' => SucursalResource::collection($sucursales),
            'roles' => ['admin', 'tecnico'],
        ]);
    }

    /**
     * Store a newly created user.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'numero_empleado' => $validated['numero_empleado'] ?? null,
            'sucursal_id' => $validated['sucursal_id'] ?? null,
        ]);

        // Assign the role
        $user->assignRole($validated['role']);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user): Response
    {
        $this->authorize('view', $user);

        $user->load(['sucursal', 'roles']);

        return Inertia::render('Admin/Users/Show', [
            'user' => new UserResource($user),
        ]);
    }

    /**
     * Remove the specified user.
     */
    public function destroy(User $user): RedirectResponse
    {
        $this->authorize('delete', $user);

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Usuario eliminado exitosamente.');
    }
}
