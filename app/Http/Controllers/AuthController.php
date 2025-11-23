<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validación de datos
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'user_type' => 'required|in:art_lover,artist,artisan,cultural_manager',
            'terms' => 'required|accepted'
        ], [
            'terms.accepted' => 'Debes aceptar los términos y condiciones.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'email.unique' => 'Este correo electrónico ya está registrado.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Generar username único
        $baseUsername = Str::slug($request->name);
        $username = $baseUsername;
        $counter = 1;

        // Verificar si el username ya existe y generar uno único
        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }

        // Crear usuario con todos los campos requeridos
        $user = User::create([
            'name' => $request->name,
            'username' => $username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => $request->user_type,
            'city' => 'Popayán',
            'status' => 'active',
            'email_verified_at' => null,
            'bio' => null,
            'profile_image' => null,
            'cover_image' => null,
            'phone' => null,
            'website' => null,
            'social_links' => null,
            'date_of_birth' => null,
            'gender' => null,
            'preferences' => null,
            'last_login_at' => null,
            'is_verified' => false
        ]);

        // Redireccionar con mensaje de éxito
        return redirect()->route('login')
            ->with('success', '¡Cuenta creada exitosamente! Ahora puedes iniciar sesión.');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Esto lo implementaremos después del registro
        return redirect()->route('home');
    }

    public function logout(Request $request)
    {
        // Esto lo implementaremos después del login
        return redirect()->route('home');
    }
}