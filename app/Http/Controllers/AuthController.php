<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validación de datos CORREGIDA con los valores que SÍ funcionan
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'user_type' => 'required|in:cultural_manager,artist,visitor,admin', // ✅ VALORES CORRECTOS
            'terms' => 'required|accepted'
        ], [
            'name.required' => 'El nombre completo es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El formato del correo no es válido.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'user_type.required' => 'Debes seleccionar un tipo de usuario.',
            'user_type.in' => 'El tipo de usuario seleccionado no es válido. Usa: Gestor Cultural, Artista o Visitante.',
            'terms.accepted' => 'Debes aceptar los términos y condiciones.'
        ]);

        if ($validator->fails()) {
            Log::error('Error de validación en registro:', $validator->errors()->toArray());
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Por favor corrige los errores del formulario.');
        }

        // Generar username único
        $baseUsername = Str::slug($request->name);
        $username = $baseUsername;
        $counter = 1;

        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }

        // DEBUG: Log para ver qué se está creando
        Log::info('Intentando crear usuario:', [
            'name' => $request->name,
            'email' => $request->email,
            'user_type' => $request->user_type,
            'username' => $username
        ]);

        try {
            // Crear usuario - versión SIMPLIFICADA con solo campos necesarios
            $user = User::create([
                'name' => trim($request->name),
                'username' => $username,
                'email' => strtolower(trim($request->email)),
                'password' => Hash::make($request->password),
                'user_type' => $request->user_type,
                'city' => 'Popayán',
                'status' => 'active',
                'email_verified_at' => null,
                // Solo campos requeridos, omitir los opcionales que pueden causar error
            ]);

            Log::info('✅ Usuario creado exitosamente:', [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email
            ]);

            // Auto-login después del registro
            Auth::login($user);

            return redirect('/')->with('success', '¡Cuenta creada exitosamente! Bienvenido/a a nuestra comunidad.');

        } catch (\Exception $e) {
            // Capturar cualquier error en la creación
            Log::error('❌ Error al crear usuario: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al crear la cuenta: ' . $e->getMessage());
        }
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'password.required' => 'La contraseña es obligatoria.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Credenciales inválidas.');
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            // Actualizar last_login_at - CORREGIDO
            $user = Auth::user();
            $user->last_login_at = now();
            $user->save();
            
            Log::info('✅ Login exitoso:', ['user_id' => $user->id, 'email' => $user->email]);
            
            return redirect()->intended('/')->with('success', '¡Bienvenido/a de nuevo!');
        }

        Log::warning('❌ Login fallido:', ['email' => $request->email]);
        
        return redirect()->back()
            ->withErrors(['email' => 'Las credenciales no coinciden con nuestros registros.'])
            ->withInput()
            ->with('error', 'Error al iniciar sesión.');
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        Log::info('✅ Logout exitoso:', ['user_id' => $user?->id]);
        
        return redirect('/')->with('success', 'Sesión cerrada correctamente.');
    }
}

