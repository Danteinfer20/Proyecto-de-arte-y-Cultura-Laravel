<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the users (solo para administradores)
     */
    public function index()
    {
        // Verificar que el usuario sea administrador
        if (Auth::user()->user_type !== 'admin') {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        $users = User::latest()->paginate(10);

        return view('users.index', compact('users'));
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        if (Auth::user()->user_type !== 'admin') {
            abort(403, 'No tienes permisos para realizar esta acción.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'user_type' => 'required|in:visitor,artist,cultural_manager,admin',
            'status' => 'required|in:active,inactive',
        ]);

        $user->update($validated);

        return redirect()->route('users.index')
                        ->with('success', 'Usuario actualizado correctamente.');
    }
}